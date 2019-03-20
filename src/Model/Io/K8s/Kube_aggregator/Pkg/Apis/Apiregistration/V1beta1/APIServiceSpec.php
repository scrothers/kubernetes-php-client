<?php

namespace Kubernetes\Model\Io\K8s\Kube_aggregator\Pkg\Apis\Apiregistration\V1beta1;

/**
 * APIServiceSpec contains information for locating and communicating with a
 * server. Only https is supported, though you are able to disable certificate
 * verification.
 */
class APIServiceSpec extends \KubernetesRuntime\AbstractModel
{

    /**
     * CABundle is a PEM encoded CA bundle which will be used to validate an API
     * server's serving certificate.
     *
     * @var string
     */
    public $caBundle = null;

    /**
     * Group is the API group name this server hosts
     *
     * @var string
     */
    public $group = null;

    /**
     * GroupPriorityMininum is the priority this group should have at least. Higher
     * priority means that the group is preferred by clients over lower priority ones.
     * Note that other versions of this group might specify even higher
     * GroupPriorityMininum values such that the whole group gets a higher priority.
     * The primary sort is based on GroupPriorityMinimum, ordered highest number to
     * lowest (20 before 10). The secondary sort is based on the alphabetical
     * comparison of the name of the object.  (v1.bar before v1.foo) We'd recommend
     * something like: *.k8s.io (except extensions) at 18000 and PaaSes (OpenShift,
     * Deis) are recommended to be in the 2000s
     *
     * @var integer
     */
    public $groupPriorityMinimum = null;

    /**
     * InsecureSkipTLSVerify disables TLS certificate verification when communicating
     * with this server. This is strongly discouraged.  You should use the CABundle
     * instead.
     *
     * @var boolean
     */
    public $insecureSkipTLSVerify = null;

    /**
     * Service is a reference to the service for this API server.  It must communicate
     * on port 443 If the Service is nil, that means the handling for the API
     * groupversion is handled locally on this server. The call will simply delegate to
     * the normal handler chain to be fulfilled.
     *
     * @var ServiceReference
     */
    public $service = null;

    /**
     * Version is the API version this server hosts.  For example, "v1"
     *
     * @var string
     */
    public $version = null;

    /**
     * VersionPriority controls the ordering of this API version inside of its group. 
     * Must be greater than zero. The primary sort is based on VersionPriority, ordered
     * highest to lowest (20 before 10). The secondary sort is based on the
     * alphabetical comparison of the name of the object.  (v1.bar before v1.foo) Since
     * it's inside of a group, the number can be small, probably in the 10s.
     *
     * @var integer
     */
    public $versionPriority = null;


}

