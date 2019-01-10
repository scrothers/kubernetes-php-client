<?php

namespace CodeGenerator\Code;

use CodeGenerator\Utility;
use OpenAPI\Schema\V2\DataTypes;
use OpenAPI\Schema\V2\SchemaObject;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlock\Tag\VarTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\PropertyGenerator;

class Model extends AbstractClassFile
{
    protected $kubernetesNamespace = 'Kubernetes\\Model\\';

    /**
     * @var SchemaObject
     */
    protected $SchemaObject;

    /**
     * Model constructor.
     *
     * @param string       $classname
     * @param SchemaObject $SchemaObject
     *
     * @throws \Exception
     */
    public function __construct(string $classname, SchemaObject $SchemaObject)
    {
        parent::__construct([]);

        [$objectNamespace, $objectClassname] = Utility::parseClassInfo(Utility::convertRefToClass($classname));
        $this->setNamespace($this->kubernetesNamespace . $objectNamespace);

        $this->SchemaObject = $SchemaObject;

        $this->ClassGenerator = new ClassGenerator();
        $this->ClassGenerator
            ->setNamespaceName($this->namespace)
            ->setName($objectClassname)
            ->addProperties($this->parseProperties())
            ->setExtendedClass('\KubernetesRuntime\AbstractModel');

        $this->setClass($this->ClassGenerator);


        if ($SchemaObject->description) {
            $SchemaObject->description = $this->parseDescription($SchemaObject->description);

            $DocBlockGenerator = new DocBlockGenerator($SchemaObject->description);
            $this->checkAndAddDeprecatedTag($SchemaObject->description, $DocBlockGenerator);

            $this->ClassGenerator->setDocBlock($DocBlockGenerator);
        }

        if ($SchemaObject->type) {
            $this->ClassGenerator->addProperty('isRawObject', true, PropertyGenerator::FLAG_PROTECTED);
        }

        $this->initFilename();
    }

    /**
     * @return PropertyGenerator[]
     *
     * @throws \Exception
     */
    function parseProperties()
    {
        $properties = [];

        foreach ((array)$this->SchemaObject->properties as $key => $property) {

            if (false !== strpos($key, '$')) {
                $key = str_replace('$', '_', $key);
            }

            $PropertyGenerator = new PropertyGenerator($key);
            $PropertyGenerator->setFlags(PropertyGenerator::FLAG_PUBLIC);

            $property['description'] = array_key_exists('description', $property)
                ? $this->parseDescription($property['description']) : '';

            $DocBlockGenerator = new DocBlockGenerator($property['description']);

            // Setup correct phpdocumentation @var tag
            if (array_key_exists('$ref', $property)) {
                $DocBlockGenerator->setTag(new VarTag(null, $this->parseDataType($property['$ref'], false)));
            }

            if (array_key_exists('type', $property)) {
                switch ($property['type']) {
                    case 'array':
                        $Tag = new VarTag(null, array_map(function ($item) {
                            return $this->parseDataType($item, true);
                        }, $property['items']));
                        break;
                    default:
                        $property['type'] = $this->parseDataType($property['type'], false);

                        $Tag = new VarTag(null, $property['type']);
                        break;
                }
                $DocBlockGenerator->setTag($Tag);
            }

            // Mark property as DEPRECATED when we detect the keyword in description
            if (in_array('description', $property)) {
                $this->checkAndAddDeprecatedTag($property['description'], $DocBlockGenerator);
            }

            // Parse value for special kubernetes keywords such as kind and apiversion
            $groupVersionKind = $this->SchemaObject->getPatternedField(KubernetesExtentions::GROUP_VERSION_KIND);
            if ('kind' == $key &&
                is_array($groupVersionKind) &&
                array_key_exists(KubernetesExtentions::KIND, $groupVersionKind[0])) {
                $PropertyGenerator->setDefaultValue($groupVersionKind[0][KubernetesExtentions::KIND]);
            }
            if ('apiVersion' == $key) {
                $apiVersion = '';
                if (is_array($groupVersionKind) &&
                    array_key_exists(KubernetesExtentions::GROUP, $groupVersionKind[0]) &&
                    '' != $groupVersionKind[0][KubernetesExtentions::GROUP]
                ) {
                    $apiVersion .= $groupVersionKind[0][KubernetesExtentions::GROUP] . "/";
                }

                if (is_array($groupVersionKind) &&
                    array_key_exists(KubernetesExtentions::VERSION, $groupVersionKind[0]) &&
                    $groupVersionKind[0][KubernetesExtentions::VERSION]
                ) {
                    $apiVersion .= $groupVersionKind[0][KubernetesExtentions::VERSION];
                }
                if ('' != $apiVersion) {
                    $PropertyGenerator->setDefaultValue($apiVersion);
                }
            }
            $PropertyGenerator->setDocBlock($DocBlockGenerator);
            $properties[] = $PropertyGenerator;
        }

        return $properties;
    }

    /**
     * @param string $dataType
     * @param bool   $isArray
     *
     * @return string
     * @throws \Exception
     */
    protected
    function parseDataType(
        string $dataType,
        $isArray = false
    ): string {
        if (0 === strpos($dataType, '#')) {
            $dataType = '\\' . $this->kubernetesNamespace . Utility::convertRefToClass($dataType);

            // If referenced datatype is within the same namespace, we don't need to import full namespace
            if (1 === strpos($dataType, $this->getNamespace())) {
                $dataType = str_replace('\\' . $this->getNamespace() . '\\', '', $dataType);
            }
        } else {
            if (array_key_exists($dataType, DataTypes::DATATYPES)) {
                $dataType = DataTypes::getPHPDataType($dataType);
            }
        }

        if ($isArray) {
            $dataType .= '[]';
        }

        return $dataType;
    }


}