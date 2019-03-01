<?php

namespace Kubernetes\API;

use \Kubernetes\Model\Io\K8s\Api\Core\V1\EventList as EventList;
use \Kubernetes\Model\Io\K8s\Api\Core\V1\Event as TheEvent;
use \Kubernetes\Model\Io\K8s\Apimachinery\Pkg\Apis\Meta\V1\Status as Status;
use \Kubernetes\Model\Io\K8s\Apimachinery\Pkg\Apis\Meta\V1\DeleteOptions as DeleteOptions;
use \Kubernetes\Model\Io\K8s\Apimachinery\Pkg\Apis\Meta\V1\Patch as Patch;
use \Kubernetes\Model\Io\K8s\Apimachinery\Pkg\Apis\Meta\V1\WatchEvent as WatchEvent;
use \Kubernetes\Model\Io\K8s\Api\Events\V1beta1\EventList as EventListV1beta1;
use \Kubernetes\Model\Io\K8s\Api\Events\V1beta1\Event as TheEventV1beta1;

class Event extends \KubernetesRuntime\AbstractAPI
{

    /**
     * list or watch objects of kind Event
     *
     * @return EventList|mixed
     */
    public function listForAllNamespaces()
    {
        return $this->parseResponse(
        	$this->client->request('get',
        		"/api/v1/events"
        		,[
        		]
        	)
        	, 'listCoreV1EventForAllNamespaces'
        );
    }

    /**
     * list or watch objects of kind Event
     *
     * @configkey continue	string
     * @configkey fieldSelector	string
     * @configkey includeUninitialized	boolean
     * @configkey labelSelector	string
     * @configkey limit	integer
     * @configkey resourceVersion	string
     * @configkey timeoutSeconds	integer
     * @configkey watch	boolean
     * @configkey continue	string
     * @configkey fieldSelector	string
     * @configkey includeUninitialized	boolean
     * @configkey labelSelector	string
     * @configkey limit	integer
     * @configkey resourceVersion	string
     * @configkey timeoutSeconds	integer
     * @configkey watch	boolean
     * @param $namespace
     * @param array $queries
     * @return EventList|mixed
     */
    public function list($namespace = 'default', array $queries = [])
    {
        return $this->parseResponse(
        	$this->client->request('get',
        		"/api/v1/namespaces/{$namespace}/events"
        		,[
        			'query' => $queries,
        		]
        	)
        	, 'listCoreV1NamespacedEvent'
        );
    }

    /**
     * create an Event
     *
     * @param $namespace
     * @param TheEvent $Model
     * @return TheEvent|mixed
     */
    public function create($namespace = 'default', \Kubernetes\Model\Io\K8s\Api\Core\V1\Event $Model)
    {
        return $this->parseResponse(
        	$this->client->request('post',
        		"/api/v1/namespaces/{$namespace}/events"
        		,[
        			'json' => $Model->getArrayCopy(),
        		]
        	)
        	, 'createCoreV1NamespacedEvent'
        );
    }

    /**
     * delete collection of Event
     *
     * @configkey continue	string
     * @configkey fieldSelector	string
     * @configkey includeUninitialized	boolean
     * @configkey labelSelector	string
     * @configkey limit	integer
     * @configkey resourceVersion	string
     * @configkey timeoutSeconds	integer
     * @configkey watch	boolean
     * @configkey continue	string
     * @configkey fieldSelector	string
     * @configkey includeUninitialized	boolean
     * @configkey labelSelector	string
     * @configkey limit	integer
     * @configkey resourceVersion	string
     * @configkey timeoutSeconds	integer
     * @configkey watch	boolean
     * @param $namespace
     * @param array $queries
     * @return Status|mixed
     */
    public function deleteCollection($namespace = 'default', array $queries = [])
    {
        return $this->parseResponse(
        	$this->client->request('delete',
        		"/api/v1/namespaces/{$namespace}/events"
        		,[
        			'query' => $queries,
        		]
        	)
        	, 'deleteCoreV1CollectionNamespacedEvent'
        );
    }

    /**
     * read the specified Event
     *
     * @configkey exact	boolean
     * @configkey export	boolean
     * @configkey exact	boolean
     * @configkey export	boolean
     * @param $namespace
     * @param $name
     * @param array $queries
     * @return TheEvent|mixed
     */
    public function read($namespace = 'default', $name, array $queries = [])
    {
        return $this->parseResponse(
        	$this->client->request('get',
        		"/api/v1/namespaces/{$namespace}/events/{$name}"
        		,[
        			'query' => $queries,
        		]
        	)
        	, 'readCoreV1NamespacedEvent'
        );
    }

    /**
     * replace the specified Event
     *
     * @param $namespace
     * @param $name
     * @param TheEvent $Model
     * @return TheEvent|mixed
     */
    public function replace($namespace = 'default', $name, \Kubernetes\Model\Io\K8s\Api\Core\V1\Event $Model)
    {
        return $this->parseResponse(
        	$this->client->request('put',
        		"/api/v1/namespaces/{$namespace}/events/{$name}"
        		,[
        			'json' => $Model->getArrayCopy(),
        		]
        	)
        	, 'replaceCoreV1NamespacedEvent'
        );
    }

    /**
     * delete an Event
     *
     * @configkey gracePeriodSeconds	integer
     * @configkey orphanDependents	boolean
     * @configkey propagationPolicy	string
     * @configkey gracePeriodSeconds	integer
     * @configkey orphanDependents	boolean
     * @configkey propagationPolicy	string
     * @param $namespace
     * @param $name
     * @param DeleteOptions $Model
     * @param array $queries
     * @return Status|mixed
     */
    public function delete($namespace = 'default', $name, \Kubernetes\Model\Io\K8s\Apimachinery\Pkg\Apis\Meta\V1\DeleteOptions $Model, array $queries = [])
    {
        return $this->parseResponse(
        	$this->client->request('delete',
        		"/api/v1/namespaces/{$namespace}/events/{$name}"
        		,[
        			'json' => $Model->getArrayCopy(),
        			'query' => $queries,
        		]
        	)
        	, 'deleteCoreV1NamespacedEvent'
        );
    }

    /**
     * partially update the specified Event
     *
     * @param $namespace
     * @param $name
     * @param Patch $Model
     * @return TheEvent|mixed
     */
    public function patch($namespace = 'default', $name, \Kubernetes\Model\Io\K8s\Apimachinery\Pkg\Apis\Meta\V1\Patch $Model)
    {
        return $this->parseResponse(
        	$this->client->request('patch',
        		"/api/v1/namespaces/{$namespace}/events/{$name}"
        		,[
        			'json' => $Model->getArrayCopy(),
        		]
        	)
        	, 'patchCoreV1NamespacedEvent'
        );
    }

    /**
     * watch individual changes to a list of Event
     *
     * @return WatchEvent|mixed
     */
    public function watchListForAllNamespaces()
    {
        return $this->parseResponse(
        	$this->client->request('get',
        		"/api/v1/watch/events"
        		,[
        		]
        	)
        	, 'watchCoreV1EventListForAllNamespaces'
        );
    }

    /**
     * watch individual changes to a list of Event
     *
     * @param $namespace
     * @return WatchEvent|mixed
     */
    public function watchList($namespace = 'default')
    {
        return $this->parseResponse(
        	$this->client->request('get',
        		"/api/v1/watch/namespaces/{$namespace}/events"
        		,[
        		]
        	)
        	, 'watchCoreV1NamespacedEventList'
        );
    }

    /**
     * watch changes to an object of kind Event
     *
     * @param $namespace
     * @param $name
     * @return WatchEvent|mixed
     */
    public function watch($namespace = 'default', $name)
    {
        return $this->parseResponse(
        	$this->client->request('get',
        		"/api/v1/watch/namespaces/{$namespace}/events/{$name}"
        		,[
        		]
        	)
        	, 'watchCoreV1NamespacedEvent'
        );
    }

    /**
     * list or watch objects of kind Event
     *
     * @return EventListV1beta1|mixed
     */
    public function listForAllNamespacesEventsV1beta1()
    {
        return $this->parseResponse(
        	$this->client->request('get',
        		"/apis/events.k8s.io/v1beta1/events"
        		,[
        		]
        	)
        	, 'listEventsV1beta1EventForAllNamespaces'
        );
    }

    /**
     * list or watch objects of kind Event
     *
     * @configkey continue	string
     * @configkey fieldSelector	string
     * @configkey includeUninitialized	boolean
     * @configkey labelSelector	string
     * @configkey limit	integer
     * @configkey resourceVersion	string
     * @configkey timeoutSeconds	integer
     * @configkey watch	boolean
     * @configkey continue	string
     * @configkey fieldSelector	string
     * @configkey includeUninitialized	boolean
     * @configkey labelSelector	string
     * @configkey limit	integer
     * @configkey resourceVersion	string
     * @configkey timeoutSeconds	integer
     * @configkey watch	boolean
     * @param $namespace
     * @param array $queries
     * @return EventListV1beta1|mixed
     */
    public function listEventsV1beta1($namespace = 'default', array $queries = [])
    {
        return $this->parseResponse(
        	$this->client->request('get',
        		"/apis/events.k8s.io/v1beta1/namespaces/{$namespace}/events"
        		,[
        			'query' => $queries,
        		]
        	)
        	, 'listEventsV1beta1NamespacedEvent'
        );
    }

    /**
     * create an Event
     *
     * @param $namespace
     * @param TheEventV1beta1 $Model
     * @return TheEventV1beta1|mixed
     */
    public function createEventsV1beta1($namespace = 'default', \Kubernetes\Model\Io\K8s\Api\Events\V1beta1\Event $Model)
    {
        return $this->parseResponse(
        	$this->client->request('post',
        		"/apis/events.k8s.io/v1beta1/namespaces/{$namespace}/events"
        		,[
        			'json' => $Model->getArrayCopy(),
        		]
        	)
        	, 'createEventsV1beta1NamespacedEvent'
        );
    }

    /**
     * delete collection of Event
     *
     * @configkey continue	string
     * @configkey fieldSelector	string
     * @configkey includeUninitialized	boolean
     * @configkey labelSelector	string
     * @configkey limit	integer
     * @configkey resourceVersion	string
     * @configkey timeoutSeconds	integer
     * @configkey watch	boolean
     * @configkey continue	string
     * @configkey fieldSelector	string
     * @configkey includeUninitialized	boolean
     * @configkey labelSelector	string
     * @configkey limit	integer
     * @configkey resourceVersion	string
     * @configkey timeoutSeconds	integer
     * @configkey watch	boolean
     * @param $namespace
     * @param array $queries
     * @return Status|mixed
     */
    public function deleteCollectionEventsV1beta1($namespace = 'default', array $queries = [])
    {
        return $this->parseResponse(
        	$this->client->request('delete',
        		"/apis/events.k8s.io/v1beta1/namespaces/{$namespace}/events"
        		,[
        			'query' => $queries,
        		]
        	)
        	, 'deleteEventsV1beta1CollectionNamespacedEvent'
        );
    }

    /**
     * read the specified Event
     *
     * @configkey exact	boolean
     * @configkey export	boolean
     * @configkey exact	boolean
     * @configkey export	boolean
     * @param $namespace
     * @param $name
     * @param array $queries
     * @return TheEventV1beta1|mixed
     */
    public function readEventsV1beta1($namespace = 'default', $name, array $queries = [])
    {
        return $this->parseResponse(
        	$this->client->request('get',
        		"/apis/events.k8s.io/v1beta1/namespaces/{$namespace}/events/{$name}"
        		,[
        			'query' => $queries,
        		]
        	)
        	, 'readEventsV1beta1NamespacedEvent'
        );
    }

    /**
     * replace the specified Event
     *
     * @param $namespace
     * @param $name
     * @param TheEventV1beta1 $Model
     * @return TheEventV1beta1|mixed
     */
    public function replaceEventsV1beta1($namespace = 'default', $name, \Kubernetes\Model\Io\K8s\Api\Events\V1beta1\Event $Model)
    {
        return $this->parseResponse(
        	$this->client->request('put',
        		"/apis/events.k8s.io/v1beta1/namespaces/{$namespace}/events/{$name}"
        		,[
        			'json' => $Model->getArrayCopy(),
        		]
        	)
        	, 'replaceEventsV1beta1NamespacedEvent'
        );
    }

    /**
     * delete an Event
     *
     * @configkey gracePeriodSeconds	integer
     * @configkey orphanDependents	boolean
     * @configkey propagationPolicy	string
     * @configkey gracePeriodSeconds	integer
     * @configkey orphanDependents	boolean
     * @configkey propagationPolicy	string
     * @param $namespace
     * @param $name
     * @param DeleteOptions $Model
     * @param array $queries
     * @return Status|mixed
     */
    public function deleteEventsV1beta1($namespace = 'default', $name, \Kubernetes\Model\Io\K8s\Apimachinery\Pkg\Apis\Meta\V1\DeleteOptions $Model, array $queries = [])
    {
        return $this->parseResponse(
        	$this->client->request('delete',
        		"/apis/events.k8s.io/v1beta1/namespaces/{$namespace}/events/{$name}"
        		,[
        			'json' => $Model->getArrayCopy(),
        			'query' => $queries,
        		]
        	)
        	, 'deleteEventsV1beta1NamespacedEvent'
        );
    }

    /**
     * partially update the specified Event
     *
     * @param $namespace
     * @param $name
     * @param Patch $Model
     * @return TheEventV1beta1|mixed
     */
    public function patchEventsV1beta1($namespace = 'default', $name, \Kubernetes\Model\Io\K8s\Apimachinery\Pkg\Apis\Meta\V1\Patch $Model)
    {
        return $this->parseResponse(
        	$this->client->request('patch',
        		"/apis/events.k8s.io/v1beta1/namespaces/{$namespace}/events/{$name}"
        		,[
        			'json' => $Model->getArrayCopy(),
        		]
        	)
        	, 'patchEventsV1beta1NamespacedEvent'
        );
    }

    /**
     * watch individual changes to a list of Event
     *
     * @return WatchEvent|mixed
     */
    public function watchListForAllNamespacesEventsV1beta1()
    {
        return $this->parseResponse(
        	$this->client->request('get',
        		"/apis/events.k8s.io/v1beta1/watch/events"
        		,[
        		]
        	)
        	, 'watchEventsV1beta1EventListForAllNamespaces'
        );
    }

    /**
     * watch individual changes to a list of Event
     *
     * @param $namespace
     * @return WatchEvent|mixed
     */
    public function watchListEventsV1beta1($namespace = 'default')
    {
        return $this->parseResponse(
        	$this->client->request('get',
        		"/apis/events.k8s.io/v1beta1/watch/namespaces/{$namespace}/events"
        		,[
        		]
        	)
        	, 'watchEventsV1beta1NamespacedEventList'
        );
    }

    /**
     * watch changes to an object of kind Event
     *
     * @param $namespace
     * @param $name
     * @return WatchEvent|mixed
     */
    public function watchEventsV1beta1($namespace = 'default', $name)
    {
        return $this->parseResponse(
        	$this->client->request('get',
        		"/apis/events.k8s.io/v1beta1/watch/namespaces/{$namespace}/events/{$name}"
        		,[
        		]
        	)
        	, 'watchEventsV1beta1NamespacedEvent'
        );
    }


}

