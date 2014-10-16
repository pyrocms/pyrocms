<?php
namespace Illuminate\Contracts\Container;

use Closure;
interface Container
{
    public function bound($abstract);
    public function alias($abstract, $alias);
    public function tag($abstract, $tags);
    public function tagged($tag);
    public function bind($abstract, $concrete = null, $shared = false);
    public function bindIf($abstract, $concrete = null, $shared = false);
    public function singleton($abstract, $concrete = null);
    public function extend($abstract, Closure $closure);
    public function when($concrete);
    public function make($abstract, $parameters = array());
    public function call($callback, array $parameters = array(), $defaultMethod = null);
    public function resolved($abstract);
    public function resolving($abstract, Closure $callback);
    public function resolvingAny(Closure $callback);
}
namespace Illuminate\Contracts\Container;

interface ContextualBindingBuilder
{
    public function needs($abstract);
    public function give($implementation);
}
namespace Illuminate\Contracts\Support;

interface Renderable
{
    public function render();
}
namespace Illuminate\Contracts\Support;

interface ResponsePreparer
{
    public function prepareResponse($value);
    public function readyForResponses();
}
namespace Illuminate\Contracts\Logging;

interface Log
{
    public function alert($message, array $context = array());
    public function critical($message, array $context = array());
    public function error($message, array $context = array());
    public function warning($message, array $context = array());
    public function notice($message, array $context = array());
    public function info($message, array $context = array());
    public function debug($message, array $context = array());
    public function log($level, $message, array $context = array());
    public function useFiles($path, $level = 'debug');
    public function useDailyFiles($path, $days = 0, $level = 'debug');
}
namespace Illuminate\Contracts\Exception;

use Closure;
use Exception;
interface Handler
{
    public function error(Closure $callback);
    public function pushError(Closure $callback);
    public function handleException(Exception $exception);
}
namespace Illuminate\Contracts\Config;

interface Repository
{
    public function has($key);
    public function get($key, $default = null);
    public function set($key, $value);
}
namespace Illuminate\Contracts\Events;

interface Dispatcher
{
    public function listen($events, $listener, $priority = 0);
    public function hasListeners($eventName);
    public function until($event, $payload = array());
    public function fire($event, $payload = array(), $halt = false);
    public function firing();
    public function forget($event);
    public function forgetQueued();
}
namespace Illuminate\Contracts\Support;

interface Arrayable
{
    public function toArray();
}
namespace Illuminate\Contracts\Support;

interface Jsonable
{
    public function toJson($options = 0);
}
namespace Illuminate\Contracts\Cookie;

interface Factory
{
    public function make($name, $value, $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = true);
    public function forever($name, $value, $path = null, $domain = null, $secure = false, $httpOnly = true);
    public function forget($name, $path = null, $domain = null);
}
namespace Illuminate\Contracts\Cookie;

interface QueueingFactory extends Factory
{
    public function queue();
    public function unqueue($name);
    public function getQueuedCookies();
}
namespace Illuminate\Contracts\Encryption;

interface Encrypter
{
    public function encrypt($value);
    public function decrypt($payload);
    public function setMode($mode);
    public function setCipher($cipher);
}
namespace Illuminate\Contracts\Queue;

interface QueueableEntity
{
    public function getQueueableId();
}
namespace Illuminate\Contracts\Routing;

use Closure;
interface Registrar
{
    public function get($uri, $action);
    public function post($uri, $action);
    public function put($uri, $action);
    public function delete($uri, $action);
    public function patch($uri, $action);
    public function options($uri, $action);
    public function match($methods, $uri, $action);
    public function resource($name, $controller, array $options = array());
    public function group(array $attributes, Closure $callback);
    public function before($callback);
    public function after($callback);
    public function filter($name, $callback);
}
namespace Illuminate\Contracts\Routing;

interface ResponseFactory
{
    public function make($content = '', $status = 200, array $headers = array());
    public function view($view, $data = array(), $status = 200, array $headers = array());
    public function json($data = array(), $status = 200, array $headers = array(), $options = 0);
    public function jsonp($callback, $data = array(), $status = 200, array $headers = array(), $options = 0);
    public function stream($callback, $status = 200, array $headers = array());
    public function download($file, $name = null, array $headers = array(), $disposition = 'attachment');
    public function redirectTo($path, $status = 302, $headers = array(), $secure = null);
    public function redirectToRoute($route, $parameters = array(), $status = 302, $headers = array());
    public function redirectToAction($action, $parameters = array(), $status = 302, $headers = array());
    public function redirectGuest($path, $status = 302, $headers = array(), $secure = null);
    public function redirectToIntended($default = '/', $status = 302, $headers = array(), $secure = null);
}
namespace Illuminate\Contracts\Routing;

interface UrlGenerator
{
    public function to($path, $extra = array(), $secure = null);
    public function secure($path, $parameters = array());
    public function asset($path, $secure = null);
    public function route($name, $parameters = array(), $absolute = true);
    public function action($action, $parameters = array(), $absolute = true);
    public function setRootControllerNamespace($rootNamespace);
}
namespace Illuminate\Contracts\Routing;

interface UrlRoutable
{
    public function getRouteKey();
    public function getRouteKeyName();
}
namespace Illuminate\Contracts\Routing;

use Closure;
interface Middleware
{
    public function handle($request, Closure $next);
}
namespace Illuminate\Contracts\View;

interface Factory
{
    public function exists($view);
    public function make($view, $data = array(), $mergeData = array());
    public function share($key, $value = null);
    public function composer($views, $callback, $priority = null);
    public function creator($views, $callback);
    public function addNamespace($namespace, $hints);
}
namespace Illuminate\Contracts\Support;

interface MessageProvider
{
    public function getMessageBag();
}
namespace Illuminate\Contracts\Support;

interface MessageBag
{
    public function keys();
    public function add($key, $message);
    public function merge($messages);
    public function has($key = null);
    public function first($key = null, $format = null);
    public function get($key, $format = null);
    public function all($format = null);
    public function getFormat();
    public function setFormat($format = ':message');
    public function isEmpty();
    public function count();
    public function toArray();
}
namespace Illuminate\Contracts\View;

use Illuminate\Contracts\Support\Renderable;
interface View extends Renderable
{
    public function name();
    public function with($key, $value = null);
}
namespace Illuminate\Container;

use Closure;
use ArrayAccess;
use ReflectionClass;
use ReflectionMethod;
use ReflectionFunction;
use ReflectionParameter;
use Illuminate\Contracts\Container\Container as ContainerContract;
class Container implements ArrayAccess, ContainerContract
{
    protected $resolved = array();
    protected $bindings = array();
    protected $instances = array();
    protected $aliases = array();
    protected $tags = array();
    protected $buildStack = array();
    public $contextual = array();
    protected $reboundCallbacks = array();
    protected $resolvingCallbacks = array();
    protected $globalResolvingCallbacks = array();
    protected $globalAfterResolvingCallbacks = array();
    public function when($concrete)
    {
        return new ContextualBindingBuilder($this, $concrete);
    }
    protected function resolvable($abstract)
    {
        return $this->bound($abstract) || $this->isAlias($abstract);
    }
    public function bound($abstract)
    {
        return isset($this->bindings[$abstract]) || isset($this->instances[$abstract]);
    }
    public function resolved($abstract)
    {
        return isset($this->resolved[$abstract]) || isset($this->instances[$abstract]);
    }
    public function isAlias($name)
    {
        return isset($this->aliases[$name]);
    }
    public function bind($abstract, $concrete = null, $shared = false)
    {
        if (is_array($abstract)) {
            list($abstract, $alias) = $this->extractAlias($abstract);
            $this->alias($abstract, $alias);
        }
        $this->dropStaleInstances($abstract);
        if (is_null($concrete)) {
            $concrete = $abstract;
        }
        if (!$concrete instanceof Closure) {
            $concrete = $this->getClosure($abstract, $concrete);
        }
        $this->bindings[$abstract] = compact('concrete', 'shared');
        if ($this->resolved($abstract)) {
            $this->rebound($abstract);
        }
    }
    protected function getClosure($abstract, $concrete)
    {
        return function ($c, $parameters = array()) use($abstract, $concrete) {
            $method = $abstract == $concrete ? 'build' : 'make';
            return $c->{$method}($concrete, $parameters);
        };
    }
    public function addContextualBinding($concrete, $abstract, $implementation)
    {
        $this->contextual[$concrete][$abstract] = $implementation;
    }
    public function bindIf($abstract, $concrete = null, $shared = false)
    {
        if (!$this->bound($abstract)) {
            $this->bind($abstract, $concrete, $shared);
        }
    }
    public function singleton($abstract, $concrete = null)
    {
        $this->bind($abstract, $concrete, true);
    }
    public function share(Closure $closure)
    {
        return function ($container) use($closure) {
            static $object;
            if (is_null($object)) {
                $object = $closure($container);
            }
            return $object;
        };
    }
    public function bindShared($abstract, Closure $closure)
    {
        $this->bind($abstract, $this->share($closure), true);
    }
    public function extend($abstract, Closure $closure)
    {
        if (!isset($this->bindings[$abstract])) {
            throw new \InvalidArgumentException("Type {$abstract} is not bound.");
        }
        if (isset($this->instances[$abstract])) {
            $this->instances[$abstract] = $closure($this->instances[$abstract], $this);
            $this->rebound($abstract);
        } else {
            $extender = $this->getExtender($abstract, $closure);
            $this->bind($abstract, $extender, $this->isShared($abstract));
        }
    }
    protected function getExtender($abstract, Closure $closure)
    {
        $resolver = $this->bindings[$abstract]['concrete'];
        return function ($container) use($resolver, $closure) {
            return $closure($resolver($container), $container);
        };
    }
    public function instance($abstract, $instance)
    {
        if (is_array($abstract)) {
            list($abstract, $alias) = $this->extractAlias($abstract);
            $this->alias($abstract, $alias);
        }
        unset($this->aliases[$abstract]);
        $bound = $this->bound($abstract);
        $this->instances[$abstract] = $instance;
        if ($bound) {
            $this->rebound($abstract);
        }
    }
    public function tag($abstracts, $tags)
    {
        $tags = is_array($tags) ? $tags : array_slice(func_get_args(), 1);
        foreach ($tags as $tag) {
            array_add($this->tags, $tag, array());
            foreach ((array) $abstracts as $abstract) {
                $this->tags[$tag][] = $abstract;
            }
        }
    }
    public function tagged($tag)
    {
        $results = array();
        foreach ($this->tags[$tag] as $abstract) {
            $results[] = $this->make($abstract);
        }
        return $results;
    }
    public function alias($abstract, $alias)
    {
        $this->aliases[$alias] = $abstract;
    }
    protected function extractAlias(array $definition)
    {
        return array(key($definition), current($definition));
    }
    public function rebinding($abstract, Closure $callback)
    {
        $this->reboundCallbacks[$abstract][] = $callback;
        if ($this->bound($abstract)) {
            return $this->make($abstract);
        }
    }
    public function refresh($abstract, $target, $method)
    {
        return $this->rebinding($abstract, function ($app, $instance) use($target, $method) {
            $target->{$method}($instance);
        });
    }
    protected function rebound($abstract)
    {
        $instance = $this->make($abstract);
        foreach ($this->getReboundCallbacks($abstract) as $callback) {
            call_user_func($callback, $this, $instance);
        }
    }
    protected function getReboundCallbacks($abstract)
    {
        if (isset($this->reboundCallbacks[$abstract])) {
            return $this->reboundCallbacks[$abstract];
        }
        return array();
    }
    public function wrap(Closure $callback, array $parameters = array())
    {
        return function () use($callback, $parameters) {
            return $this->call($callback, $parameters);
        };
    }
    public function call($callback, array $parameters = array(), $defaultMethod = null)
    {
        if (is_string($callback)) {
            return $this->callClass($callback, $parameters, $defaultMethod);
        }
        $dependencies = $this->getMethodDependencies($callback, $parameters);
        return call_user_func_array($callback, $dependencies);
    }
    protected function getMethodDependencies($callback, $parameters = array())
    {
        $dependencies = array();
        foreach ($this->getCallReflector($callback)->getParameters() as $key => $parameter) {
            $this->addDependencyForCallParameter($parameter, $parameters, $dependencies);
        }
        return array_merge($dependencies, $parameters);
    }
    protected function getCallReflector($callback)
    {
        if (is_array($callback)) {
            return new ReflectionMethod($callback[0], $callback[1]);
        } else {
            return new ReflectionFunction($callback);
        }
    }
    protected function addDependencyForCallParameter(ReflectionParameter $parameter, array &$parameters, &$dependencies)
    {
        if (array_key_exists($parameter->name, $parameters)) {
            $dependencies[] = $parameters[$parameter->name];
            unset($parameters[$parameter->name]);
        } elseif ($parameter->getClass()) {
            $dependencies[] = $this->make($parameter->getClass()->name);
        } elseif ($parameter->isDefaultValueAvailable()) {
            $dependencies[] = $parameter->getDefaultValue();
        }
    }
    protected function callClass($target, array $parameters = array(), $defaultMethod = null)
    {
        $segments = explode('@', $target);
        $method = count($segments) == 2 ? $segments[1] : $defaultMethod;
        if (is_null($method)) {
            throw new \InvalidArgumentException('Method not provided.');
        }
        return $this->call(array($this->make($segments[0]), $method), $parameters);
    }
    public function make($abstract, $parameters = array())
    {
        $abstract = $this->getAlias($abstract);
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }
        $concrete = $this->getConcrete($abstract);
        if ($this->isBuildable($concrete, $abstract)) {
            $object = $this->build($concrete, $parameters);
        } else {
            $object = $this->make($concrete, $parameters);
        }
        if ($this->isShared($abstract)) {
            $this->instances[$abstract] = $object;
        }
        $this->fireResolvingCallbacks($abstract, $object);
        $this->resolved[$abstract] = true;
        return $object;
    }
    protected function getConcrete($abstract)
    {
        if (!is_null($concrete = $this->getContextualConcrete($abstract))) {
            return $concrete;
        }
        if (!isset($this->bindings[$abstract])) {
            if ($this->missingLeadingSlash($abstract) && isset($this->bindings['\\' . $abstract])) {
                $abstract = '\\' . $abstract;
            }
            return $abstract;
        }
        return $this->bindings[$abstract]['concrete'];
    }
    protected function getContextualConcrete($abstract)
    {
        if (isset($this->contextual[last($this->buildStack)][$abstract])) {
            return $this->contextual[last($this->buildStack)][$abstract];
        }
    }
    protected function missingLeadingSlash($abstract)
    {
        return is_string($abstract) && strpos($abstract, '\\') !== 0;
    }
    public function build($concrete, $parameters = array())
    {
        if ($concrete instanceof Closure) {
            return $concrete($this, $parameters);
        }
        $reflector = new ReflectionClass($concrete);
        if (!$reflector->isInstantiable()) {
            $message = "Target [{$concrete}] is not instantiable.";
            throw new BindingResolutionException($message);
        }
        $this->buildStack[] = $concrete;
        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            array_pop($this->buildStack);
            return new $concrete();
        }
        $dependencies = $constructor->getParameters();
        $parameters = $this->keyParametersByArgument($dependencies, $parameters);
        $instances = $this->getDependencies($dependencies, $parameters);
        array_pop($this->buildStack);
        return $reflector->newInstanceArgs($instances);
    }
    protected function getDependencies($parameters, array $primitives = array())
    {
        $dependencies = array();
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();
            if (array_key_exists($parameter->name, $primitives)) {
                $dependencies[] = $primitives[$parameter->name];
            } elseif (is_null($dependency)) {
                $dependencies[] = $this->resolveNonClass($parameter);
            } else {
                $dependencies[] = $this->resolveClass($parameter);
            }
        }
        return (array) $dependencies;
    }
    protected function resolveNonClass(ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }
        $message = "Unresolvable dependency resolving [{$parameter}] in class {$parameter->getDeclaringClass()->getName()}";
        throw new BindingResolutionException($message);
    }
    protected function resolveClass(ReflectionParameter $parameter)
    {
        try {
            return $this->make($parameter->getClass()->name);
        } catch (BindingResolutionException $e) {
            if ($parameter->isOptional()) {
                return $parameter->getDefaultValue();
            }
            throw $e;
        }
    }
    protected function keyParametersByArgument(array $dependencies, array $parameters)
    {
        foreach ($parameters as $key => $value) {
            if (is_numeric($key)) {
                unset($parameters[$key]);
                $parameters[$dependencies[$key]->name] = $value;
            }
        }
        return $parameters;
    }
    public function resolving($abstract, Closure $callback)
    {
        $this->resolvingCallbacks[$abstract][] = $callback;
    }
    public function resolvingAny(Closure $callback)
    {
        $this->globalResolvingCallbacks[] = $callback;
    }
    public function afterResolvingAny(Closure $callback)
    {
        $this->globalAfterResolvingCallbacks[] = $callback;
    }
    protected function fireResolvingCallbacks($abstract, $object)
    {
        if (isset($this->resolvingCallbacks[$abstract])) {
            $this->fireCallbackArray($object, $this->resolvingCallbacks[$abstract]);
        }
        $this->fireCallbackArray($object, $this->globalResolvingCallbacks);
        $this->fireCallbackArray($object, $this->globalAfterResolvingCallbacks);
    }
    protected function fireCallbackArray($object, array $callbacks)
    {
        foreach ($callbacks as $callback) {
            $callback($object, $this);
        }
    }
    public function isShared($abstract)
    {
        if (isset($this->bindings[$abstract]['shared'])) {
            $shared = $this->bindings[$abstract]['shared'];
        } else {
            $shared = false;
        }
        return isset($this->instances[$abstract]) || $shared === true;
    }
    protected function isBuildable($concrete, $abstract)
    {
        return $concrete === $abstract || $concrete instanceof Closure;
    }
    protected function getAlias($abstract)
    {
        return isset($this->aliases[$abstract]) ? $this->aliases[$abstract] : $abstract;
    }
    public function getBindings()
    {
        return $this->bindings;
    }
    protected function dropStaleInstances($abstract)
    {
        unset($this->instances[$abstract], $this->aliases[$abstract]);
    }
    public function forgetInstance($abstract)
    {
        unset($this->instances[$abstract]);
    }
    public function forgetInstances()
    {
        $this->instances = array();
    }
    public function flush()
    {
        $this->aliases = array();
        $this->resolved = array();
        $this->bindings = array();
        $this->instances = array();
    }
    public function offsetExists($key)
    {
        return isset($this->bindings[$key]);
    }
    public function offsetGet($key)
    {
        return $this->make($key);
    }
    public function offsetSet($key, $value)
    {
        if (!$value instanceof Closure) {
            $value = function () use($value) {
                return $value;
            };
        }
        $this->bind($key, $value);
    }
    public function offsetUnset($key)
    {
        unset($this->bindings[$key], $this->instances[$key]);
    }
    public function __get($key)
    {
        return $this[$key];
    }
    public function __set($key, $value)
    {
        $this[$key] = $value;
    }
}
namespace Symfony\Component\HttpKernel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
interface HttpKernelInterface
{
    const MASTER_REQUEST = 1;
    const SUB_REQUEST = 2;
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true);
}
namespace Symfony\Component\HttpKernel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
interface TerminableInterface
{
    public function terminate(Request $request, Response $response);
}
namespace Illuminate\Foundation;

use Closure;
use Stack\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Config\FileLoader;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Routing\RoutingServiceProvider;
use Illuminate\Contracts\Support\ResponsePreparer;
use Illuminate\Exception\ExceptionServiceProvider;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
class Application extends Container implements HttpKernelInterface, TerminableInterface, ApplicationContract, ResponsePreparer
{
    const VERSION = '5.0-dev';
    protected $booted = false;
    protected $bootingCallbacks = array();
    protected $bootedCallbacks = array();
    protected $finishCallbacks = array();
    protected $shutdownCallbacks = array();
    protected $serviceProviders = array();
    protected $loadedProviders = array();
    protected $deferredServices = array();
    protected $stack;
    protected static $requestClass = 'Illuminate\\Http\\Request';
    public function __construct(Request $request = null)
    {
        $this->registerBaseBindings($request ?: $this->createNewRequest());
        $this->registerBaseServiceProviders();
    }
    protected function createNewRequest()
    {
        return forward_static_call(array(static::$requestClass, 'createFromGlobals'));
    }
    protected function registerBaseBindings($request)
    {
        $this->instance('request', $request);
        $this->instance('Illuminate\\Container\\Container', $this);
    }
    protected function registerBaseServiceProviders()
    {
        foreach (array('Event', 'Exception', 'Routing') as $name) {
            $this->{"register{$name}Provider"}();
        }
    }
    protected function registerExceptionProvider()
    {
        $this->register(new ExceptionServiceProvider($this));
    }
    protected function registerRoutingProvider()
    {
        $this->register(new RoutingServiceProvider($this));
    }
    protected function registerEventProvider()
    {
        $this->register(new EventServiceProvider($this));
    }
    public function bindInstallPaths(array $paths)
    {
        $this->instance('path', realpath($paths['app']));
        foreach (array_except($paths, array('app')) as $key => $value) {
            $this->instance("path.{$key}", realpath($value));
        }
    }
    public static function getBootstrapFile()
    {
        return '/home/vagrant/html/streams/vendor/laravel/framework/src/Illuminate/Foundation' . '/start.php';
    }
    public function startExceptionHandling()
    {
        $this['exception']->register($this->environment());
        $this['exception']->setDebug($this['config']['app.debug']);
    }
    public function environment()
    {
        if (count(func_get_args()) > 0) {
            return in_array($this['env'], func_get_args());
        }
        return $this['env'];
    }
    public function isLocal()
    {
        return $this['env'] == 'local';
    }
    public function detectEnvironment($envs)
    {
        $args = isset($_SERVER['argv']) ? $_SERVER['argv'] : null;
        return $this['env'] = (new EnvironmentDetector())->detect($envs, $args);
    }
    public function runningInConsole()
    {
        return php_sapi_name() == 'cli';
    }
    public function runningUnitTests()
    {
        return $this['env'] == 'testing';
    }
    public function forceRegister($provider, $options = array())
    {
        return $this->register($provider, $options, true);
    }
    public function register($provider, $options = array(), $force = false)
    {
        if ($registered = $this->getRegistered($provider) && !$force) {
            return $registered;
        }
        if (is_string($provider)) {
            $provider = $this->resolveProviderClass($provider);
        }
        $provider->register();
        foreach ($options as $key => $value) {
            $this[$key] = $value;
        }
        $this->markAsRegistered($provider);
        if ($this->booted) {
            $this->bootProvider($provider);
        }
        return $provider;
    }
    public function getRegistered($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);
        return array_first($this->serviceProviders, function ($key, $value) use($name) {
            return $value instanceof $name;
        });
    }
    public function resolveProviderClass($provider)
    {
        return new $provider($this);
    }
    protected function markAsRegistered($provider)
    {
        $this['events']->fire($class = get_class($provider), array($provider));
        $this->serviceProviders[] = $provider;
        $this->loadedProviders[$class] = true;
    }
    public function loadDeferredProviders()
    {
        foreach ($this->deferredServices as $service => $provider) {
            $this->loadDeferredProvider($service);
        }
        $this->deferredServices = array();
    }
    protected function loadDeferredProvider($service)
    {
        $provider = $this->deferredServices[$service];
        if (!isset($this->loadedProviders[$provider])) {
            $this->registerDeferredProvider($provider, $service);
        }
    }
    public function registerDeferredProvider($provider, $service = null)
    {
        if ($service) {
            unset($this->deferredServices[$service]);
        }
        $this->register($instance = new $provider($this));
        if (!$this->booted) {
            $this->booting(function () use($instance) {
                $this->bootProvider($instance);
            });
        }
    }
    public function make($abstract, $parameters = array())
    {
        $abstract = $this->getAlias($abstract);
        if (isset($this->deferredServices[$abstract])) {
            $this->loadDeferredProvider($abstract);
        }
        return parent::make($abstract, $parameters);
    }
    public function bound($abstract)
    {
        return isset($this->deferredServices[$abstract]) || parent::bound($abstract);
    }
    public function extend($abstract, Closure $closure)
    {
        $abstract = $this->getAlias($abstract);
        if (isset($this->deferredServices[$abstract])) {
            $this->loadDeferredProvider($abstract);
        }
        return parent::extend($abstract, $closure);
    }
    public function finish($callback)
    {
        $this->finishCallbacks[] = $callback;
    }
    public function shutdown(callable $callback = null)
    {
        if (is_null($callback)) {
            $this->fireAppCallbacks($this->shutdownCallbacks);
        } else {
            $this->shutdownCallbacks[] = $callback;
        }
    }
    public function useArraySessions(Closure $callback)
    {
        $this->bind('session.reject', function () use($callback) {
            return $callback;
        });
    }
    public function isBooted()
    {
        return $this->booted;
    }
    public function boot()
    {
        if ($this->booted) {
            return;
        }
        array_walk($this->serviceProviders, function ($p) {
            $this->bootProvider($p);
        });
        $this->bootApplication();
    }
    protected function bootApplication()
    {
        $this->fireAppCallbacks($this->bootingCallbacks);
        $this->booted = true;
        $this->fireAppCallbacks($this->bootedCallbacks);
    }
    public function booting($callback)
    {
        $this->bootingCallbacks[] = $callback;
    }
    public function booted($callback)
    {
        $this->bootedCallbacks[] = $callback;
        if ($this->isBooted()) {
            $this->fireAppCallbacks(array($callback));
        }
    }
    protected function bootProvider(ServiceProvider $provider)
    {
        if (method_exists($provider, 'boot')) {
            return $this->call(array($provider, 'boot'));
        }
    }
    public function routesAreCached()
    {
        return $this['files']->exists($this->getCachedRoutesPath());
    }
    public function getCachedRoutesPath()
    {
        return $this['path.storage'] . '/framework/routes.php';
    }
    public function routesAreScanned()
    {
        return $this['files']->exists($this->getScannedRoutesPath());
    }
    public function getScannedRoutesPath()
    {
        return $this['path.storage'] . '/framework/routes.scanned.php';
    }
    public function eventsAreScanned()
    {
        return $this['files']->exists($this->getScannedEventsPath());
    }
    public function getScannedEventsPath()
    {
        return $this['path.storage'] . '/framework/events.scanned.php';
    }
    public function stack(Closure $stack)
    {
        $this->stack = $stack;
        return $this;
    }
    public function run(SymfonyRequest $request = null)
    {
        $request = $request ?: $this['request'];
        with($response = $this->handleRequest($request))->send();
        $this->terminate($request, $response);
    }
    public function handle(SymfonyRequest $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        try {
            return $this->handleRequest($request);
        } catch (\Exception $e) {
            if ($this->runningUnitTests()) {
                throw $e;
            }
            return $this['exception']->handleException($e);
        }
    }
    protected function handleRequest(SymfonyRequest $request = null)
    {
        $request = $request ?: $this['request'];
        $this->refreshRequest($request = Request::createFromBase($request));
        $this->boot();
        return with($stack = $this->call($this->stack))->setContainer($this)->run($request);
    }
    public function terminate(SymfonyRequest $request, SymfonyResponse $response)
    {
        $this->callFinishCallbacks($request, $response);
        $this->shutdown();
    }
    protected function refreshRequest(Request $request)
    {
        $this->instance('request', $request);
        Facade::clearResolvedInstance('request');
    }
    public function callFinishCallbacks(SymfonyRequest $request, SymfonyResponse $response)
    {
        foreach ($this->finishCallbacks as $callback) {
            call_user_func($callback, $request, $response);
        }
    }
    protected function fireAppCallbacks(array $callbacks)
    {
        foreach ($callbacks as $callback) {
            call_user_func($callback, $this);
        }
    }
    public function prepareResponse($value)
    {
        if (!$value instanceof SymfonyResponse) {
            $value = new Response($value);
        }
        return $value->prepare($this['request']);
    }
    public function readyForResponses()
    {
        return $this->booted;
    }
    public function isDownForMaintenance()
    {
        return file_exists($this['config']['app.manifest'] . '/down');
    }
    public function down(Closure $callback)
    {
        $this['events']->listen('illuminate.app.down', $callback);
    }
    public function abort($code, $message = '', array $headers = array())
    {
        if ($code == 404) {
            throw new NotFoundHttpException($message);
        }
        throw new HttpException($code, $message, null, $headers);
    }
    public function getConfigLoader()
    {
        return new FileLoader(new Filesystem(), $this['path.config']);
    }
    public function getProviderRepository()
    {
        $manifest = $this['config']['app.manifest'];
        return new ProviderRepository(new Filesystem(), $manifest);
    }
    public function getLoadedProviders()
    {
        return $this->loadedProviders;
    }
    public function setDeferredServices(array $services)
    {
        $this->deferredServices = $services;
    }
    public function isDeferredService($service)
    {
        return isset($this->deferredServices[$service]);
    }
    public static function requestClass($class = null)
    {
        if (!is_null($class)) {
            static::$requestClass = $class;
        }
        return static::$requestClass;
    }
    public function setRequestForConsoleEnvironment()
    {
        $url = $this['config']->get('app.url', 'http://localhost');
        $parameters = array($url, 'GET', array(), array(), array(), $_SERVER);
        $this->refreshRequest(static::onRequest('create', $parameters));
    }
    public static function onRequest($method, $parameters = array())
    {
        return forward_static_call_array(array(static::requestClass(), $method), $parameters);
    }
    public function getLocale()
    {
        return $this['config']->get('app.locale');
    }
    public function setLocale($locale)
    {
        $this['config']->set('app.locale', $locale);
        $this['translator']->setLocale($locale);
        $this['events']->fire('locale.changed', array($locale));
    }
    public function registerCoreContainerAliases()
    {
        $aliases = array('app' => array('Illuminate\\Foundation\\Application', 'Illuminate\\Contracts\\Container\\Container', 'Illuminate\\Contracts\\Foundation\\Application'), 'artisan' => array('Illuminate\\Console\\Application', 'Illuminate\\Contracts\\Console\\Application'), 'auth' => 'Illuminate\\Auth\\AuthManager', 'auth.driver' => array('Illuminate\\Auth\\Guard', 'Illuminate\\Contracts\\Auth\\Guard'), 'auth.password.tokens' => 'Illuminate\\Auth\\Passwords\\TokenRepositoryInterface', 'blade.compiler' => 'Illuminate\\View\\Compilers\\BladeCompiler', 'cache' => array('Illuminate\\Cache\\CacheManager', 'Illuminate\\Contracts\\Cache\\Factory'), 'cache.store' => array('Illuminate\\Cache\\Repository', 'Illuminate\\Contracts\\Cache\\Repository'), 'config' => array('Illuminate\\Config\\Repository', 'Illuminate\\Contracts\\Config\\Repository'), 'cookie' => array('Illuminate\\Cookie\\CookieJar', 'Illuminate\\Contracts\\Cookie\\Factory', 'Illuminate\\Contracts\\Cookie\\QueueingFactory'), 'exception' => 'Illuminate\\Contracts\\Exception\\Handler', 'encrypter' => array('Illuminate\\Encryption\\Encrypter', 'Illuminate\\Contracts\\Encryption\\Encrypter'), 'db' => 'Illuminate\\Database\\DatabaseManager', 'events' => array('Illuminate\\Events\\Dispatcher', 'Illuminate\\Contracts\\Events\\Dispatcher'), 'files' => 'Illuminate\\Filesystem\\Filesystem', 'filesystem' => 'Illuminate\\Contracts\\Filesystem\\Factory', 'filesystem.disk' => 'Illuminate\\Contracts\\Filesystem\\Filesystem', 'filesystem.cloud' => 'Illuminate\\Contracts\\Filesystem\\Cloud', 'hash' => 'Illuminate\\Contracts\\Hashing\\Hasher', 'translator' => array('Illuminate\\Translation\\Translator', 'Symfony\\Component\\Translation\\TranslatorInterface'), 'log' => array('Illuminate\\Log\\Writer', 'Illuminate\\Contracts\\Logging\\Log', 'Psr\\Log\\LoggerInterface'), 'mailer' => array('Illuminate\\Mail\\Mailer', 'Illuminate\\Contracts\\Mail\\Mailer', 'Illuminate\\Contracts\\Mail\\MailQueue'), 'paginator' => 'Illuminate\\Pagination\\Factory', 'auth.password' => array('Illuminate\\Auth\\Passwords\\PasswordBroker', 'Illuminate\\Contracts\\Auth\\PasswordBroker'), 'queue' => array('Illuminate\\Queue\\QueueManager', 'Illuminate\\Contracts\\Queue\\Factory', 'Illuminate\\Contracts\\Queue\\Monitor'), 'queue.connection' => 'Illuminate\\Contracts\\Queue\\Queue', 'redirect' => 'Illuminate\\Routing\\Redirector', 'redis' => array('Illuminate\\Redis\\Database', 'Illuminate\\Contracts\\Redis\\Database'), 'request' => 'Illuminate\\Http\\Request', 'router' => array('Illuminate\\Routing\\Router', 'Illuminate\\Contracts\\Routing\\Registrar'), 'session' => 'Illuminate\\Session\\SessionManager', 'session.store' => array('Illuminate\\Session\\Store', 'Symfony\\Component\\HttpFoundation\\Session\\SessionInterface'), 'url' => array('Illuminate\\Routing\\UrlGenerator', 'Illuminate\\Contracts\\Routing\\UrlGenerator'), 'validator' => array('Illuminate\\Validation\\Factory', 'Illuminate\\Contracts\\Validation\\Factory'), 'view' => array('Illuminate\\View\\Factory', 'Illuminate\\Contracts\\View\\Factory'));
        foreach ($aliases as $key => $aliases) {
            foreach ((array) $aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }
    public function flush()
    {
        parent::flush();
        $this->loadedProviders = array();
    }
}
namespace Illuminate\Foundation;

use Closure;
class EnvironmentDetector
{
    public function detect($environments, $consoleArgs = null)
    {
        if ($consoleArgs) {
            return $this->detectConsoleEnvironment($environments, $consoleArgs);
        }
        return $this->detectWebEnvironment($environments);
    }
    protected function detectWebEnvironment($environments)
    {
        if ($environments instanceof Closure) {
            return call_user_func($environments);
        }
        foreach ($environments as $environment => $hosts) {
            foreach ((array) $hosts as $host) {
                if ($this->isMachine($host)) {
                    return $environment;
                }
            }
        }
        return 'production';
    }
    protected function detectConsoleEnvironment($environments, array $args)
    {
        if (!is_null($value = $this->getEnvironmentArgument($args))) {
            return head(array_slice(explode('=', $value), 1));
        }
        return $this->detectWebEnvironment($environments);
    }
    protected function getEnvironmentArgument(array $args)
    {
        return array_first($args, function ($k, $v) {
            return starts_with($v, '--env');
        });
    }
    public function isMachine($name)
    {
        return str_is($name, gethostname());
    }
}
namespace Illuminate\Http;

use Closure;
use SplFileInfo;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
class Request extends SymfonyRequest
{
    protected $json;
    protected $sessionStore;
    protected $userResolver;
    protected $routeResolver;
    public function instance()
    {
        return $this;
    }
    public function method()
    {
        return $this->getMethod();
    }
    public function root()
    {
        return rtrim($this->getSchemeAndHttpHost() . $this->getBaseUrl(), '/');
    }
    public function url()
    {
        return rtrim(preg_replace('/\\?.*/', '', $this->getUri()), '/');
    }
    public function fullUrl()
    {
        $query = $this->getQueryString();
        return $query ? $this->url() . '?' . $query : $this->url();
    }
    public function path()
    {
        $pattern = trim($this->getPathInfo(), '/');
        return $pattern == '' ? '/' : $pattern;
    }
    public function decodedPath()
    {
        return rawurldecode($this->path());
    }
    public function segment($index, $default = null)
    {
        return array_get($this->segments(), $index - 1, $default);
    }
    public function segments()
    {
        $segments = explode('/', $this->path());
        return array_values(array_filter($segments, function ($v) {
            return $v != '';
        }));
    }
    public function is()
    {
        foreach (func_get_args() as $pattern) {
            if (str_is($pattern, urldecode($this->path()))) {
                return true;
            }
        }
        return false;
    }
    public function ajax()
    {
        return $this->isXmlHttpRequest();
    }
    public function secure()
    {
        return $this->isSecure();
    }
    public function ip()
    {
        return $this->getClientIp();
    }
    public function ips()
    {
        return $this->getClientIps();
    }
    public function exists($key)
    {
        $keys = is_array($key) ? $key : func_get_args();
        $input = $this->all();
        foreach ($keys as $value) {
            if (!array_key_exists($value, $input)) {
                return false;
            }
        }
        return true;
    }
    public function has($key)
    {
        $keys = is_array($key) ? $key : func_get_args();
        foreach ($keys as $value) {
            if ($this->isEmptyString($value)) {
                return false;
            }
        }
        return true;
    }
    protected function isEmptyString($key)
    {
        $boolOrArray = is_bool($this->input($key)) || is_array($this->input($key));
        return !$boolOrArray && trim((string) $this->input($key)) === '';
    }
    public function all()
    {
        return array_replace_recursive($this->input(), $this->files->all());
    }
    public function input($key = null, $default = null)
    {
        $input = $this->getInputSource()->all() + $this->query->all();
        return array_get($input, $key, $default);
    }
    public function only($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        $results = array();
        $input = $this->all();
        foreach ($keys as $key) {
            array_set($results, $key, array_get($input, $key));
        }
        return $results;
    }
    public function except($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        $results = $this->all();
        array_forget($results, $keys);
        return $results;
    }
    public function query($key = null, $default = null)
    {
        return $this->retrieveItem('query', $key, $default);
    }
    public function hasCookie($key)
    {
        return !is_null($this->cookie($key));
    }
    public function cookie($key = null, $default = null)
    {
        return $this->retrieveItem('cookies', $key, $default);
    }
    public function file($key = null, $default = null)
    {
        return array_get($this->files->all(), $key, $default);
    }
    public function hasFile($key)
    {
        if (!is_array($files = $this->file($key))) {
            $files = array($files);
        }
        foreach ($files as $file) {
            if ($this->isValidFile($file)) {
                return true;
            }
        }
        return false;
    }
    protected function isValidFile($file)
    {
        return $file instanceof SplFileInfo && $file->getPath() != '';
    }
    public function header($key = null, $default = null)
    {
        return $this->retrieveItem('headers', $key, $default);
    }
    public function server($key = null, $default = null)
    {
        return $this->retrieveItem('server', $key, $default);
    }
    public function old($key = null, $default = null)
    {
        return $this->session()->getOldInput($key, $default);
    }
    public function flash($filter = null, $keys = array())
    {
        $flash = !is_null($filter) ? $this->{$filter}($keys) : $this->input();
        $this->session()->flashInput($flash);
    }
    public function flashOnly($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        return $this->flash('only', $keys);
    }
    public function flashExcept($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        return $this->flash('except', $keys);
    }
    public function flush()
    {
        $this->session()->flashInput(array());
    }
    protected function retrieveItem($source, $key, $default)
    {
        if (is_null($key)) {
            return $this->{$source}->all();
        }
        return $this->{$source}->get($key, $default, true);
    }
    public function merge(array $input)
    {
        $this->getInputSource()->add($input);
    }
    public function replace(array $input)
    {
        $this->getInputSource()->replace($input);
    }
    public function json($key = null, $default = null)
    {
        if (!isset($this->json)) {
            $this->json = new ParameterBag((array) json_decode($this->getContent(), true));
        }
        if (is_null($key)) {
            return $this->json;
        }
        return array_get($this->json->all(), $key, $default);
    }
    protected function getInputSource()
    {
        if ($this->isJson()) {
            return $this->json();
        }
        return $this->getMethod() == 'GET' ? $this->query : $this->request;
    }
    public function isJson()
    {
        return str_contains($this->header('CONTENT_TYPE'), '/json');
    }
    public function wantsJson()
    {
        $acceptable = $this->getAcceptableContentTypes();
        return isset($acceptable[0]) && $acceptable[0] == 'application/json';
    }
    public function format($default = 'html')
    {
        foreach ($this->getAcceptableContentTypes() as $type) {
            if ($format = $this->getFormat($type)) {
                return $format;
            }
        }
        return $default;
    }
    public static function createFromBase(SymfonyRequest $request)
    {
        if ($request instanceof static) {
            return $request;
        }
        return (new static())->duplicate($request->query->all(), $request->request->all(), $request->attributes->all(), $request->cookies->all(), $request->files->all(), $request->server->all());
    }
    public function session()
    {
        if (!$this->hasSession()) {
            throw new \RuntimeException('Session store not set on request.');
        }
        return $this->getSession();
    }
    public function user()
    {
        return call_user_func($this->getUserResolver());
    }
    public function route()
    {
        return call_user_func($this->getRouteResolver());
    }
    public function getUserResolver()
    {
        return $this->userResolver ?: function () {
            
        };
    }
    public function setUserResolver(Closure $callback)
    {
        $this->userResolver = $callback;
        return $this;
    }
    public function getRouteResolver()
    {
        return $this->routeResolver ?: function () {
            
        };
    }
    public function setRouteResolver(Closure $callback)
    {
        $this->routeResolver = $callback;
        return $this;
    }
}
namespace Symfony\Component\HttpFoundation;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
class Request
{
    const HEADER_CLIENT_IP = 'client_ip';
    const HEADER_CLIENT_HOST = 'client_host';
    const HEADER_CLIENT_PROTO = 'client_proto';
    const HEADER_CLIENT_PORT = 'client_port';
    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PURGE = 'PURGE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_TRACE = 'TRACE';
    const METHOD_CONNECT = 'CONNECT';
    protected static $trustedProxies = array();
    protected static $trustedHostPatterns = array();
    protected static $trustedHosts = array();
    protected static $trustedHeaders = array(self::HEADER_CLIENT_IP => 'X_FORWARDED_FOR', self::HEADER_CLIENT_HOST => 'X_FORWARDED_HOST', self::HEADER_CLIENT_PROTO => 'X_FORWARDED_PROTO', self::HEADER_CLIENT_PORT => 'X_FORWARDED_PORT');
    protected static $httpMethodParameterOverride = false;
    public $attributes;
    public $request;
    public $query;
    public $server;
    public $files;
    public $cookies;
    public $headers;
    protected $content;
    protected $languages;
    protected $charsets;
    protected $encodings;
    protected $acceptableContentTypes;
    protected $pathInfo;
    protected $requestUri;
    protected $baseUrl;
    protected $basePath;
    protected $method;
    protected $format;
    protected $session;
    protected $locale;
    protected $defaultLocale = 'en';
    protected static $formats;
    protected static $requestFactory;
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        $this->initialize($query, $request, $attributes, $cookies, $files, $server, $content);
    }
    public function initialize(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        $this->request = new ParameterBag($request);
        $this->query = new ParameterBag($query);
        $this->attributes = new ParameterBag($attributes);
        $this->cookies = new ParameterBag($cookies);
        $this->files = new FileBag($files);
        $this->server = new ServerBag($server);
        $this->headers = new HeaderBag($this->server->getHeaders());
        $this->content = $content;
        $this->languages = null;
        $this->charsets = null;
        $this->encodings = null;
        $this->acceptableContentTypes = null;
        $this->pathInfo = null;
        $this->requestUri = null;
        $this->baseUrl = null;
        $this->basePath = null;
        $this->method = null;
        $this->format = null;
    }
    public static function createFromGlobals()
    {
        $request = self::createRequestFromFactory($_GET, $_POST, array(), $_COOKIE, $_FILES, $_SERVER);
        if (0 === strpos($request->headers->get('CONTENT_TYPE'), 'application/x-www-form-urlencoded') && in_array(strtoupper($request->server->get('REQUEST_METHOD', 'GET')), array('PUT', 'DELETE', 'PATCH'))) {
            parse_str($request->getContent(), $data);
            $request->request = new ParameterBag($data);
        }
        return $request;
    }
    public static function create($uri, $method = 'GET', $parameters = array(), $cookies = array(), $files = array(), $server = array(), $content = null)
    {
        $server = array_replace(array('SERVER_NAME' => 'localhost', 'SERVER_PORT' => 80, 'HTTP_HOST' => 'localhost', 'HTTP_USER_AGENT' => 'Symfony/2.X', 'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8', 'HTTP_ACCEPT_LANGUAGE' => 'en-us,en;q=0.5', 'HTTP_ACCEPT_CHARSET' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7', 'REMOTE_ADDR' => '127.0.0.1', 'SCRIPT_NAME' => '', 'SCRIPT_FILENAME' => '', 'SERVER_PROTOCOL' => 'HTTP/1.1', 'REQUEST_TIME' => time()), $server);
        $server['PATH_INFO'] = '';
        $server['REQUEST_METHOD'] = strtoupper($method);
        $components = parse_url($uri);
        if (isset($components['host'])) {
            $server['SERVER_NAME'] = $components['host'];
            $server['HTTP_HOST'] = $components['host'];
        }
        if (isset($components['scheme'])) {
            if ('https' === $components['scheme']) {
                $server['HTTPS'] = 'on';
                $server['SERVER_PORT'] = 443;
            } else {
                unset($server['HTTPS']);
                $server['SERVER_PORT'] = 80;
            }
        }
        if (isset($components['port'])) {
            $server['SERVER_PORT'] = $components['port'];
            $server['HTTP_HOST'] = $server['HTTP_HOST'] . ':' . $components['port'];
        }
        if (isset($components['user'])) {
            $server['PHP_AUTH_USER'] = $components['user'];
        }
        if (isset($components['pass'])) {
            $server['PHP_AUTH_PW'] = $components['pass'];
        }
        if (!isset($components['path'])) {
            $components['path'] = '/';
        }
        switch (strtoupper($method)) {
            case 'POST':
            case 'PUT':
            case 'DELETE':
                if (!isset($server['CONTENT_TYPE'])) {
                    $server['CONTENT_TYPE'] = 'application/x-www-form-urlencoded';
                }
            case 'PATCH':
                $request = $parameters;
                $query = array();
                break;
            default:
                $request = array();
                $query = $parameters;
                break;
        }
        $queryString = '';
        if (isset($components['query'])) {
            parse_str(html_entity_decode($components['query']), $qs);
            if ($query) {
                $query = array_replace($qs, $query);
                $queryString = http_build_query($query, '', '&');
            } else {
                $query = $qs;
                $queryString = $components['query'];
            }
        } elseif ($query) {
            $queryString = http_build_query($query, '', '&');
        }
        $server['REQUEST_URI'] = $components['path'] . ('' !== $queryString ? '?' . $queryString : '');
        $server['QUERY_STRING'] = $queryString;
        return self::createRequestFromFactory($query, $request, array(), $cookies, $files, $server, $content);
    }
    public static function setFactory($callable)
    {
        self::$requestFactory = $callable;
    }
    public function duplicate(array $query = null, array $request = null, array $attributes = null, array $cookies = null, array $files = null, array $server = null)
    {
        $dup = clone $this;
        if ($query !== null) {
            $dup->query = new ParameterBag($query);
        }
        if ($request !== null) {
            $dup->request = new ParameterBag($request);
        }
        if ($attributes !== null) {
            $dup->attributes = new ParameterBag($attributes);
        }
        if ($cookies !== null) {
            $dup->cookies = new ParameterBag($cookies);
        }
        if ($files !== null) {
            $dup->files = new FileBag($files);
        }
        if ($server !== null) {
            $dup->server = new ServerBag($server);
            $dup->headers = new HeaderBag($dup->server->getHeaders());
        }
        $dup->languages = null;
        $dup->charsets = null;
        $dup->encodings = null;
        $dup->acceptableContentTypes = null;
        $dup->pathInfo = null;
        $dup->requestUri = null;
        $dup->baseUrl = null;
        $dup->basePath = null;
        $dup->method = null;
        $dup->format = null;
        if (!$dup->get('_format') && $this->get('_format')) {
            $dup->attributes->set('_format', $this->get('_format'));
        }
        if (!$dup->getRequestFormat(null)) {
            $dup->setRequestFormat($format = $this->getRequestFormat(null));
        }
        return $dup;
    }
    public function __clone()
    {
        $this->query = clone $this->query;
        $this->request = clone $this->request;
        $this->attributes = clone $this->attributes;
        $this->cookies = clone $this->cookies;
        $this->files = clone $this->files;
        $this->server = clone $this->server;
        $this->headers = clone $this->headers;
    }
    public function __toString()
    {
        return sprintf('%s %s %s', $this->getMethod(), $this->getRequestUri(), $this->server->get('SERVER_PROTOCOL')) . '
' . $this->headers . '
' . $this->getContent();
    }
    public function overrideGlobals()
    {
        $this->server->set('QUERY_STRING', static::normalizeQueryString(http_build_query($this->query->all(), null, '&')));
        $_GET = $this->query->all();
        $_POST = $this->request->all();
        $_SERVER = $this->server->all();
        $_COOKIE = $this->cookies->all();
        foreach ($this->headers->all() as $key => $value) {
            $key = strtoupper(str_replace('-', '_', $key));
            if (in_array($key, array('CONTENT_TYPE', 'CONTENT_LENGTH'))) {
                $_SERVER[$key] = implode(', ', $value);
            } else {
                $_SERVER['HTTP_' . $key] = implode(', ', $value);
            }
        }
        $request = array('g' => $_GET, 'p' => $_POST, 'c' => $_COOKIE);
        $requestOrder = ini_get('request_order') ?: ini_get('variables_order');
        $requestOrder = preg_replace('#[^cgp]#', '', strtolower($requestOrder)) ?: 'gp';
        $_REQUEST = array();
        foreach (str_split($requestOrder) as $order) {
            $_REQUEST = array_merge($_REQUEST, $request[$order]);
        }
    }
    public static function setTrustedProxies(array $proxies)
    {
        self::$trustedProxies = $proxies;
    }
    public static function getTrustedProxies()
    {
        return self::$trustedProxies;
    }
    public static function setTrustedHosts(array $hostPatterns)
    {
        self::$trustedHostPatterns = array_map(function ($hostPattern) {
            return sprintf('{%s}i', str_replace('}', '\\}', $hostPattern));
        }, $hostPatterns);
        self::$trustedHosts = array();
    }
    public static function getTrustedHosts()
    {
        return self::$trustedHostPatterns;
    }
    public static function setTrustedHeaderName($key, $value)
    {
        if (!array_key_exists($key, self::$trustedHeaders)) {
            throw new \InvalidArgumentException(sprintf('Unable to set the trusted header name for key "%s".', $key));
        }
        self::$trustedHeaders[$key] = $value;
    }
    public static function getTrustedHeaderName($key)
    {
        if (!array_key_exists($key, self::$trustedHeaders)) {
            throw new \InvalidArgumentException(sprintf('Unable to get the trusted header name for key "%s".', $key));
        }
        return self::$trustedHeaders[$key];
    }
    public static function normalizeQueryString($qs)
    {
        if ('' == $qs) {
            return '';
        }
        $parts = array();
        $order = array();
        foreach (explode('&', $qs) as $param) {
            if ('' === $param || '=' === $param[0]) {
                continue;
            }
            $keyValuePair = explode('=', $param, 2);
            $parts[] = isset($keyValuePair[1]) ? rawurlencode(urldecode($keyValuePair[0])) . '=' . rawurlencode(urldecode($keyValuePair[1])) : rawurlencode(urldecode($keyValuePair[0]));
            $order[] = urldecode($keyValuePair[0]);
        }
        array_multisort($order, SORT_ASC, $parts);
        return implode('&', $parts);
    }
    public static function enableHttpMethodParameterOverride()
    {
        self::$httpMethodParameterOverride = true;
    }
    public static function getHttpMethodParameterOverride()
    {
        return self::$httpMethodParameterOverride;
    }
    public function get($key, $default = null, $deep = false)
    {
        return $this->query->get($key, $this->attributes->get($key, $this->request->get($key, $default, $deep), $deep), $deep);
    }
    public function getSession()
    {
        return $this->session;
    }
    public function hasPreviousSession()
    {
        return $this->hasSession() && $this->cookies->has($this->session->getName());
    }
    public function hasSession()
    {
        return null !== $this->session;
    }
    public function setSession(SessionInterface $session)
    {
        $this->session = $session;
    }
    public function getClientIps()
    {
        $ip = $this->server->get('REMOTE_ADDR');
        if (!self::$trustedProxies) {
            return array($ip);
        }
        if (!self::$trustedHeaders[self::HEADER_CLIENT_IP] || !$this->headers->has(self::$trustedHeaders[self::HEADER_CLIENT_IP])) {
            return array($ip);
        }
        $clientIps = array_map('trim', explode(',', $this->headers->get(self::$trustedHeaders[self::HEADER_CLIENT_IP])));
        $clientIps[] = $ip;
        $ip = $clientIps[0];
        foreach ($clientIps as $key => $clientIp) {
            if (IpUtils::checkIp($clientIp, self::$trustedProxies)) {
                unset($clientIps[$key]);
            }
        }
        return $clientIps ? array_reverse($clientIps) : array($ip);
    }
    public function getClientIp()
    {
        $ipAddresses = $this->getClientIps();
        return $ipAddresses[0];
    }
    public function getScriptName()
    {
        return $this->server->get('SCRIPT_NAME', $this->server->get('ORIG_SCRIPT_NAME', ''));
    }
    public function getPathInfo()
    {
        if (null === $this->pathInfo) {
            $this->pathInfo = $this->preparePathInfo();
        }
        return $this->pathInfo;
    }
    public function getBasePath()
    {
        if (null === $this->basePath) {
            $this->basePath = $this->prepareBasePath();
        }
        return $this->basePath;
    }
    public function getBaseUrl()
    {
        if (null === $this->baseUrl) {
            $this->baseUrl = $this->prepareBaseUrl();
        }
        return $this->baseUrl;
    }
    public function getScheme()
    {
        return $this->isSecure() ? 'https' : 'http';
    }
    public function getPort()
    {
        if (self::$trustedProxies) {
            if (self::$trustedHeaders[self::HEADER_CLIENT_PORT] && ($port = $this->headers->get(self::$trustedHeaders[self::HEADER_CLIENT_PORT]))) {
                return $port;
            }
            if (self::$trustedHeaders[self::HEADER_CLIENT_PROTO] && 'https' === $this->headers->get(self::$trustedHeaders[self::HEADER_CLIENT_PROTO], 'http')) {
                return 443;
            }
        }
        if ($host = $this->headers->get('HOST')) {
            if ($host[0] === '[') {
                $pos = strpos($host, ':', strrpos($host, ']'));
            } else {
                $pos = strrpos($host, ':');
            }
            if (false !== $pos) {
                return intval(substr($host, $pos + 1));
            }
            return 'https' === $this->getScheme() ? 443 : 80;
        }
        return $this->server->get('SERVER_PORT');
    }
    public function getUser()
    {
        return $this->headers->get('PHP_AUTH_USER');
    }
    public function getPassword()
    {
        return $this->headers->get('PHP_AUTH_PW');
    }
    public function getUserInfo()
    {
        $userinfo = $this->getUser();
        $pass = $this->getPassword();
        if ('' != $pass) {
            $userinfo .= ":{$pass}";
        }
        return $userinfo;
    }
    public function getHttpHost()
    {
        $scheme = $this->getScheme();
        $port = $this->getPort();
        if ('http' == $scheme && $port == 80 || 'https' == $scheme && $port == 443) {
            return $this->getHost();
        }
        return $this->getHost() . ':' . $port;
    }
    public function getRequestUri()
    {
        if (null === $this->requestUri) {
            $this->requestUri = $this->prepareRequestUri();
        }
        return $this->requestUri;
    }
    public function getSchemeAndHttpHost()
    {
        return $this->getScheme() . '://' . $this->getHttpHost();
    }
    public function getUri()
    {
        if (null !== ($qs = $this->getQueryString())) {
            $qs = '?' . $qs;
        }
        return $this->getSchemeAndHttpHost() . $this->getBaseUrl() . $this->getPathInfo() . $qs;
    }
    public function getUriForPath($path)
    {
        return $this->getSchemeAndHttpHost() . $this->getBaseUrl() . $path;
    }
    public function getQueryString()
    {
        $qs = static::normalizeQueryString($this->server->get('QUERY_STRING'));
        return '' === $qs ? null : $qs;
    }
    public function isSecure()
    {
        if (self::$trustedProxies && self::$trustedHeaders[self::HEADER_CLIENT_PROTO] && ($proto = $this->headers->get(self::$trustedHeaders[self::HEADER_CLIENT_PROTO]))) {
            return in_array(strtolower(current(explode(',', $proto))), array('https', 'on', 'ssl', '1'));
        }
        $https = $this->server->get('HTTPS');
        return !empty($https) && 'off' !== strtolower($https);
    }
    public function getHost()
    {
        if (self::$trustedProxies && self::$trustedHeaders[self::HEADER_CLIENT_HOST] && ($host = $this->headers->get(self::$trustedHeaders[self::HEADER_CLIENT_HOST]))) {
            $elements = explode(',', $host);
            $host = $elements[count($elements) - 1];
        } elseif (!($host = $this->headers->get('HOST'))) {
            if (!($host = $this->server->get('SERVER_NAME'))) {
                $host = $this->server->get('SERVER_ADDR', '');
            }
        }
        $host = strtolower(preg_replace('/:\\d+$/', '', trim($host)));
        if ($host && '' !== preg_replace('/(?:^\\[)?[a-zA-Z0-9-:\\]_]+\\.?/', '', $host)) {
            throw new \UnexpectedValueException(sprintf('Invalid Host "%s"', $host));
        }
        if (count(self::$trustedHostPatterns) > 0) {
            if (in_array($host, self::$trustedHosts)) {
                return $host;
            }
            foreach (self::$trustedHostPatterns as $pattern) {
                if (preg_match($pattern, $host)) {
                    self::$trustedHosts[] = $host;
                    return $host;
                }
            }
            throw new \UnexpectedValueException(sprintf('Untrusted Host "%s"', $host));
        }
        return $host;
    }
    public function setMethod($method)
    {
        $this->method = null;
        $this->server->set('REQUEST_METHOD', $method);
    }
    public function getMethod()
    {
        if (null === $this->method) {
            $this->method = strtoupper($this->server->get('REQUEST_METHOD', 'GET'));
            if ('POST' === $this->method) {
                if ($method = $this->headers->get('X-HTTP-METHOD-OVERRIDE')) {
                    $this->method = strtoupper($method);
                } elseif (self::$httpMethodParameterOverride) {
                    $this->method = strtoupper($this->request->get('_method', $this->query->get('_method', 'POST')));
                }
            }
        }
        return $this->method;
    }
    public function getRealMethod()
    {
        return strtoupper($this->server->get('REQUEST_METHOD', 'GET'));
    }
    public function getMimeType($format)
    {
        if (null === static::$formats) {
            static::initializeFormats();
        }
        return isset(static::$formats[$format]) ? static::$formats[$format][0] : null;
    }
    public function getFormat($mimeType)
    {
        if (false !== ($pos = strpos($mimeType, ';'))) {
            $mimeType = substr($mimeType, 0, $pos);
        }
        if (null === static::$formats) {
            static::initializeFormats();
        }
        foreach (static::$formats as $format => $mimeTypes) {
            if (in_array($mimeType, (array) $mimeTypes)) {
                return $format;
            }
        }
    }
    public function setFormat($format, $mimeTypes)
    {
        if (null === static::$formats) {
            static::initializeFormats();
        }
        static::$formats[$format] = is_array($mimeTypes) ? $mimeTypes : array($mimeTypes);
    }
    public function getRequestFormat($default = 'html')
    {
        if (null === $this->format) {
            $this->format = $this->get('_format', $default);
        }
        return $this->format;
    }
    public function setRequestFormat($format)
    {
        $this->format = $format;
    }
    public function getContentType()
    {
        return $this->getFormat($this->headers->get('CONTENT_TYPE'));
    }
    public function setDefaultLocale($locale)
    {
        $this->defaultLocale = $locale;
        if (null === $this->locale) {
            $this->setPhpDefaultLocale($locale);
        }
    }
    public function getDefaultLocale()
    {
        return $this->defaultLocale;
    }
    public function setLocale($locale)
    {
        $this->setPhpDefaultLocale($this->locale = $locale);
    }
    public function getLocale()
    {
        return null === $this->locale ? $this->defaultLocale : $this->locale;
    }
    public function isMethod($method)
    {
        return $this->getMethod() === strtoupper($method);
    }
    public function isMethodSafe()
    {
        return in_array($this->getMethod(), array('GET', 'HEAD'));
    }
    public function getContent($asResource = false)
    {
        if (false === $this->content || true === $asResource && null !== $this->content) {
            throw new \LogicException('getContent() can only be called once when using the resource return type.');
        }
        if (true === $asResource) {
            $this->content = false;
            return fopen('php://input', 'rb');
        }
        if (null === $this->content) {
            $this->content = file_get_contents('php://input');
        }
        return $this->content;
    }
    public function getETags()
    {
        return preg_split('/\\s*,\\s*/', $this->headers->get('if_none_match'), null, PREG_SPLIT_NO_EMPTY);
    }
    public function isNoCache()
    {
        return $this->headers->hasCacheControlDirective('no-cache') || 'no-cache' == $this->headers->get('Pragma');
    }
    public function getPreferredLanguage(array $locales = null)
    {
        $preferredLanguages = $this->getLanguages();
        if (empty($locales)) {
            return isset($preferredLanguages[0]) ? $preferredLanguages[0] : null;
        }
        if (!$preferredLanguages) {
            return $locales[0];
        }
        $extendedPreferredLanguages = array();
        foreach ($preferredLanguages as $language) {
            $extendedPreferredLanguages[] = $language;
            if (false !== ($position = strpos($language, '_'))) {
                $superLanguage = substr($language, 0, $position);
                if (!in_array($superLanguage, $preferredLanguages)) {
                    $extendedPreferredLanguages[] = $superLanguage;
                }
            }
        }
        $preferredLanguages = array_values(array_intersect($extendedPreferredLanguages, $locales));
        return isset($preferredLanguages[0]) ? $preferredLanguages[0] : $locales[0];
    }
    public function getLanguages()
    {
        if (null !== $this->languages) {
            return $this->languages;
        }
        $languages = AcceptHeader::fromString($this->headers->get('Accept-Language'))->all();
        $this->languages = array();
        foreach (array_keys($languages) as $lang) {
            if (strstr($lang, '-')) {
                $codes = explode('-', $lang);
                if ($codes[0] == 'i') {
                    if (count($codes) > 1) {
                        $lang = $codes[1];
                    }
                } else {
                    for ($i = 0, $max = count($codes); $i < $max; $i++) {
                        if ($i == 0) {
                            $lang = strtolower($codes[0]);
                        } else {
                            $lang .= '_' . strtoupper($codes[$i]);
                        }
                    }
                }
            }
            $this->languages[] = $lang;
        }
        return $this->languages;
    }
    public function getCharsets()
    {
        if (null !== $this->charsets) {
            return $this->charsets;
        }
        return $this->charsets = array_keys(AcceptHeader::fromString($this->headers->get('Accept-Charset'))->all());
    }
    public function getEncodings()
    {
        if (null !== $this->encodings) {
            return $this->encodings;
        }
        return $this->encodings = array_keys(AcceptHeader::fromString($this->headers->get('Accept-Encoding'))->all());
    }
    public function getAcceptableContentTypes()
    {
        if (null !== $this->acceptableContentTypes) {
            return $this->acceptableContentTypes;
        }
        return $this->acceptableContentTypes = array_keys(AcceptHeader::fromString($this->headers->get('Accept'))->all());
    }
    public function isXmlHttpRequest()
    {
        return 'XMLHttpRequest' == $this->headers->get('X-Requested-With');
    }
    protected function prepareRequestUri()
    {
        $requestUri = '';
        if ($this->headers->has('X_ORIGINAL_URL')) {
            $requestUri = $this->headers->get('X_ORIGINAL_URL');
            $this->headers->remove('X_ORIGINAL_URL');
            $this->server->remove('HTTP_X_ORIGINAL_URL');
            $this->server->remove('UNENCODED_URL');
            $this->server->remove('IIS_WasUrlRewritten');
        } elseif ($this->headers->has('X_REWRITE_URL')) {
            $requestUri = $this->headers->get('X_REWRITE_URL');
            $this->headers->remove('X_REWRITE_URL');
        } elseif ($this->server->get('IIS_WasUrlRewritten') == '1' && $this->server->get('UNENCODED_URL') != '') {
            $requestUri = $this->server->get('UNENCODED_URL');
            $this->server->remove('UNENCODED_URL');
            $this->server->remove('IIS_WasUrlRewritten');
        } elseif ($this->server->has('REQUEST_URI')) {
            $requestUri = $this->server->get('REQUEST_URI');
            $schemeAndHttpHost = $this->getSchemeAndHttpHost();
            if (strpos($requestUri, $schemeAndHttpHost) === 0) {
                $requestUri = substr($requestUri, strlen($schemeAndHttpHost));
            }
        } elseif ($this->server->has('ORIG_PATH_INFO')) {
            $requestUri = $this->server->get('ORIG_PATH_INFO');
            if ('' != $this->server->get('QUERY_STRING')) {
                $requestUri .= '?' . $this->server->get('QUERY_STRING');
            }
            $this->server->remove('ORIG_PATH_INFO');
        }
        $this->server->set('REQUEST_URI', $requestUri);
        return $requestUri;
    }
    protected function prepareBaseUrl()
    {
        $filename = basename($this->server->get('SCRIPT_FILENAME'));
        if (basename($this->server->get('SCRIPT_NAME')) === $filename) {
            $baseUrl = $this->server->get('SCRIPT_NAME');
        } elseif (basename($this->server->get('PHP_SELF')) === $filename) {
            $baseUrl = $this->server->get('PHP_SELF');
        } elseif (basename($this->server->get('ORIG_SCRIPT_NAME')) === $filename) {
            $baseUrl = $this->server->get('ORIG_SCRIPT_NAME');
        } else {
            $path = $this->server->get('PHP_SELF', '');
            $file = $this->server->get('SCRIPT_FILENAME', '');
            $segs = explode('/', trim($file, '/'));
            $segs = array_reverse($segs);
            $index = 0;
            $last = count($segs);
            $baseUrl = '';
            do {
                $seg = $segs[$index];
                $baseUrl = '/' . $seg . $baseUrl;
                ++$index;
            } while ($last > $index && false !== ($pos = strpos($path, $baseUrl)) && 0 != $pos);
        }
        $requestUri = $this->getRequestUri();
        if ($baseUrl && false !== ($prefix = $this->getUrlencodedPrefix($requestUri, $baseUrl))) {
            return $prefix;
        }
        if ($baseUrl && false !== ($prefix = $this->getUrlencodedPrefix($requestUri, dirname($baseUrl)))) {
            return rtrim($prefix, '/');
        }
        $truncatedRequestUri = $requestUri;
        if (false !== ($pos = strpos($requestUri, '?'))) {
            $truncatedRequestUri = substr($requestUri, 0, $pos);
        }
        $basename = basename($baseUrl);
        if (empty($basename) || !strpos(rawurldecode($truncatedRequestUri), $basename)) {
            return '';
        }
        if (strlen($requestUri) >= strlen($baseUrl) && false !== ($pos = strpos($requestUri, $baseUrl)) && $pos !== 0) {
            $baseUrl = substr($requestUri, 0, $pos + strlen($baseUrl));
        }
        return rtrim($baseUrl, '/');
    }
    protected function prepareBasePath()
    {
        $filename = basename($this->server->get('SCRIPT_FILENAME'));
        $baseUrl = $this->getBaseUrl();
        if (empty($baseUrl)) {
            return '';
        }
        if (basename($baseUrl) === $filename) {
            $basePath = dirname($baseUrl);
        } else {
            $basePath = $baseUrl;
        }
        if ('\\' === DIRECTORY_SEPARATOR) {
            $basePath = str_replace('\\', '/', $basePath);
        }
        return rtrim($basePath, '/');
    }
    protected function preparePathInfo()
    {
        $baseUrl = $this->getBaseUrl();
        if (null === ($requestUri = $this->getRequestUri())) {
            return '/';
        }
        $pathInfo = '/';
        if ($pos = strpos($requestUri, '?')) {
            $requestUri = substr($requestUri, 0, $pos);
        }
        if (null !== $baseUrl && false === ($pathInfo = substr($requestUri, strlen($baseUrl)))) {
            return '/';
        } elseif (null === $baseUrl) {
            return $requestUri;
        }
        return (string) $pathInfo;
    }
    protected static function initializeFormats()
    {
        static::$formats = array('html' => array('text/html', 'application/xhtml+xml'), 'txt' => array('text/plain'), 'js' => array('application/javascript', 'application/x-javascript', 'text/javascript'), 'css' => array('text/css'), 'json' => array('application/json', 'application/x-json'), 'xml' => array('text/xml', 'application/xml', 'application/x-xml'), 'rdf' => array('application/rdf+xml'), 'atom' => array('application/atom+xml'), 'rss' => array('application/rss+xml'), 'form' => array('application/x-www-form-urlencoded'));
    }
    private function setPhpDefaultLocale($locale)
    {
        try {
            if (class_exists('Locale', false)) {
                \Locale::setDefault($locale);
            }
        } catch (\Exception $e) {
            
        }
    }
    private function getUrlencodedPrefix($string, $prefix)
    {
        if (0 !== strpos(rawurldecode($string), $prefix)) {
            return false;
        }
        $len = strlen($prefix);
        if (preg_match("#^(%[[:xdigit:]]{2}|.){{$len}}#", $string, $match)) {
            return $match[0];
        }
        return false;
    }
    private static function createRequestFromFactory(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        if (self::$requestFactory) {
            $request = call_user_func(self::$requestFactory, $query, $request, $attributes, $cookies, $files, $server, $content);
            if (!$request instanceof Request) {
                throw new \LogicException('The Request factory must return an instance of Symfony\\Component\\HttpFoundation\\Request.');
            }
            return $request;
        }
        return new static($query, $request, $attributes, $cookies, $files, $server, $content);
    }
}
namespace Symfony\Component\HttpFoundation;

class ParameterBag implements \IteratorAggregate, \Countable
{
    protected $parameters;
    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }
    public function all()
    {
        return $this->parameters;
    }
    public function keys()
    {
        return array_keys($this->parameters);
    }
    public function replace(array $parameters = array())
    {
        $this->parameters = $parameters;
    }
    public function add(array $parameters = array())
    {
        $this->parameters = array_replace($this->parameters, $parameters);
    }
    public function get($path, $default = null, $deep = false)
    {
        if (!$deep || false === ($pos = strpos($path, '['))) {
            return array_key_exists($path, $this->parameters) ? $this->parameters[$path] : $default;
        }
        $root = substr($path, 0, $pos);
        if (!array_key_exists($root, $this->parameters)) {
            return $default;
        }
        $value = $this->parameters[$root];
        $currentKey = null;
        for ($i = $pos, $c = strlen($path); $i < $c; $i++) {
            $char = $path[$i];
            if ('[' === $char) {
                if (null !== $currentKey) {
                    throw new \InvalidArgumentException(sprintf('Malformed path. Unexpected "[" at position %d.', $i));
                }
                $currentKey = '';
            } elseif (']' === $char) {
                if (null === $currentKey) {
                    throw new \InvalidArgumentException(sprintf('Malformed path. Unexpected "]" at position %d.', $i));
                }
                if (!is_array($value) || !array_key_exists($currentKey, $value)) {
                    return $default;
                }
                $value = $value[$currentKey];
                $currentKey = null;
            } else {
                if (null === $currentKey) {
                    throw new \InvalidArgumentException(sprintf('Malformed path. Unexpected "%s" at position %d.', $char, $i));
                }
                $currentKey .= $char;
            }
        }
        if (null !== $currentKey) {
            throw new \InvalidArgumentException(sprintf('Malformed path. Path must end with "]".'));
        }
        return $value;
    }
    public function set($key, $value)
    {
        $this->parameters[$key] = $value;
    }
    public function has($key)
    {
        return array_key_exists($key, $this->parameters);
    }
    public function remove($key)
    {
        unset($this->parameters[$key]);
    }
    public function getAlpha($key, $default = '', $deep = false)
    {
        return preg_replace('/[^[:alpha:]]/', '', $this->get($key, $default, $deep));
    }
    public function getAlnum($key, $default = '', $deep = false)
    {
        return preg_replace('/[^[:alnum:]]/', '', $this->get($key, $default, $deep));
    }
    public function getDigits($key, $default = '', $deep = false)
    {
        return str_replace(array('-', '+'), '', $this->filter($key, $default, $deep, FILTER_SANITIZE_NUMBER_INT));
    }
    public function getInt($key, $default = 0, $deep = false)
    {
        return (int) $this->get($key, $default, $deep);
    }
    public function getBoolean($key, $default = false, $deep = false)
    {
        return $this->filter($key, $default, $deep, FILTER_VALIDATE_BOOLEAN);
    }
    public function filter($key, $default = null, $deep = false, $filter = FILTER_DEFAULT, $options = array())
    {
        $value = $this->get($key, $default, $deep);
        if (!is_array($options) && $options) {
            $options = array('flags' => $options);
        }
        if (is_array($value) && !isset($options['flags'])) {
            $options['flags'] = FILTER_REQUIRE_ARRAY;
        }
        return filter_var($value, $filter, $options);
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->parameters);
    }
    public function count()
    {
        return count($this->parameters);
    }
}
namespace Symfony\Component\HttpFoundation;

use Symfony\Component\HttpFoundation\File\UploadedFile;
class FileBag extends ParameterBag
{
    private static $fileKeys = array('error', 'name', 'size', 'tmp_name', 'type');
    public function __construct(array $parameters = array())
    {
        $this->replace($parameters);
    }
    public function replace(array $files = array())
    {
        $this->parameters = array();
        $this->add($files);
    }
    public function set($key, $value)
    {
        if (!is_array($value) && !$value instanceof UploadedFile) {
            throw new \InvalidArgumentException('An uploaded file must be an array or an instance of UploadedFile.');
        }
        parent::set($key, $this->convertFileInformation($value));
    }
    public function add(array $files = array())
    {
        foreach ($files as $key => $file) {
            $this->set($key, $file);
        }
    }
    protected function convertFileInformation($file)
    {
        if ($file instanceof UploadedFile) {
            return $file;
        }
        $file = $this->fixPhpFilesArray($file);
        if (is_array($file)) {
            $keys = array_keys($file);
            sort($keys);
            if ($keys == self::$fileKeys) {
                if (UPLOAD_ERR_NO_FILE == $file['error']) {
                    $file = null;
                } else {
                    $file = new UploadedFile($file['tmp_name'], $file['name'], $file['type'], $file['size'], $file['error']);
                }
            } else {
                $file = array_map(array($this, 'convertFileInformation'), $file);
            }
        }
        return $file;
    }
    protected function fixPhpFilesArray($data)
    {
        if (!is_array($data)) {
            return $data;
        }
        $keys = array_keys($data);
        sort($keys);
        if (self::$fileKeys != $keys || !isset($data['name']) || !is_array($data['name'])) {
            return $data;
        }
        $files = $data;
        foreach (self::$fileKeys as $k) {
            unset($files[$k]);
        }
        foreach (array_keys($data['name']) as $key) {
            $files[$key] = $this->fixPhpFilesArray(array('error' => $data['error'][$key], 'name' => $data['name'][$key], 'type' => $data['type'][$key], 'tmp_name' => $data['tmp_name'][$key], 'size' => $data['size'][$key]));
        }
        return $files;
    }
}
namespace Symfony\Component\HttpFoundation;

class ServerBag extends ParameterBag
{
    public function getHeaders()
    {
        $headers = array();
        $contentHeaders = array('CONTENT_LENGTH' => true, 'CONTENT_MD5' => true, 'CONTENT_TYPE' => true);
        foreach ($this->parameters as $key => $value) {
            if (0 === strpos($key, 'HTTP_')) {
                $headers[substr($key, 5)] = $value;
            } elseif (isset($contentHeaders[$key])) {
                $headers[$key] = $value;
            }
        }
        if (isset($this->parameters['PHP_AUTH_USER'])) {
            $headers['PHP_AUTH_USER'] = $this->parameters['PHP_AUTH_USER'];
            $headers['PHP_AUTH_PW'] = isset($this->parameters['PHP_AUTH_PW']) ? $this->parameters['PHP_AUTH_PW'] : '';
        } else {
            $authorizationHeader = null;
            if (isset($this->parameters['HTTP_AUTHORIZATION'])) {
                $authorizationHeader = $this->parameters['HTTP_AUTHORIZATION'];
            } elseif (isset($this->parameters['REDIRECT_HTTP_AUTHORIZATION'])) {
                $authorizationHeader = $this->parameters['REDIRECT_HTTP_AUTHORIZATION'];
            }
            if (null !== $authorizationHeader) {
                if (0 === stripos($authorizationHeader, 'basic ')) {
                    $exploded = explode(':', base64_decode(substr($authorizationHeader, 6)), 2);
                    if (count($exploded) == 2) {
                        list($headers['PHP_AUTH_USER'], $headers['PHP_AUTH_PW']) = $exploded;
                    }
                } elseif (empty($this->parameters['PHP_AUTH_DIGEST']) && 0 === stripos($authorizationHeader, 'digest ')) {
                    $headers['PHP_AUTH_DIGEST'] = $authorizationHeader;
                    $this->parameters['PHP_AUTH_DIGEST'] = $authorizationHeader;
                }
            }
        }
        if (isset($headers['PHP_AUTH_USER'])) {
            $headers['AUTHORIZATION'] = 'Basic ' . base64_encode($headers['PHP_AUTH_USER'] . ':' . $headers['PHP_AUTH_PW']);
        } elseif (isset($headers['PHP_AUTH_DIGEST'])) {
            $headers['AUTHORIZATION'] = $headers['PHP_AUTH_DIGEST'];
        }
        return $headers;
    }
}
namespace Symfony\Component\HttpFoundation;

class HeaderBag implements \IteratorAggregate, \Countable
{
    protected $headers = array();
    protected $cacheControl = array();
    public function __construct(array $headers = array())
    {
        foreach ($headers as $key => $values) {
            $this->set($key, $values);
        }
    }
    public function __toString()
    {
        if (!$this->headers) {
            return '';
        }
        $max = max(array_map('strlen', array_keys($this->headers))) + 1;
        $content = '';
        ksort($this->headers);
        foreach ($this->headers as $name => $values) {
            $name = implode('-', array_map('ucfirst', explode('-', $name)));
            foreach ($values as $value) {
                $content .= sprintf("%-{$max}s %s\r\n", $name . ':', $value);
            }
        }
        return $content;
    }
    public function all()
    {
        return $this->headers;
    }
    public function keys()
    {
        return array_keys($this->headers);
    }
    public function replace(array $headers = array())
    {
        $this->headers = array();
        $this->add($headers);
    }
    public function add(array $headers)
    {
        foreach ($headers as $key => $values) {
            $this->set($key, $values);
        }
    }
    public function get($key, $default = null, $first = true)
    {
        $key = strtr(strtolower($key), '_', '-');
        if (!array_key_exists($key, $this->headers)) {
            if (null === $default) {
                return $first ? null : array();
            }
            return $first ? $default : array($default);
        }
        if ($first) {
            return count($this->headers[$key]) ? $this->headers[$key][0] : $default;
        }
        return $this->headers[$key];
    }
    public function set($key, $values, $replace = true)
    {
        $key = strtr(strtolower($key), '_', '-');
        $values = array_values((array) $values);
        if (true === $replace || !isset($this->headers[$key])) {
            $this->headers[$key] = $values;
        } else {
            $this->headers[$key] = array_merge($this->headers[$key], $values);
        }
        if ('cache-control' === $key) {
            $this->cacheControl = $this->parseCacheControl($values[0]);
        }
    }
    public function has($key)
    {
        return array_key_exists(strtr(strtolower($key), '_', '-'), $this->headers);
    }
    public function contains($key, $value)
    {
        return in_array($value, $this->get($key, null, false));
    }
    public function remove($key)
    {
        $key = strtr(strtolower($key), '_', '-');
        unset($this->headers[$key]);
        if ('cache-control' === $key) {
            $this->cacheControl = array();
        }
    }
    public function getDate($key, \DateTime $default = null)
    {
        if (null === ($value = $this->get($key))) {
            return $default;
        }
        if (false === ($date = \DateTime::createFromFormat(DATE_RFC2822, $value))) {
            throw new \RuntimeException(sprintf('The %s HTTP header is not parseable (%s).', $key, $value));
        }
        return $date;
    }
    public function addCacheControlDirective($key, $value = true)
    {
        $this->cacheControl[$key] = $value;
        $this->set('Cache-Control', $this->getCacheControlHeader());
    }
    public function hasCacheControlDirective($key)
    {
        return array_key_exists($key, $this->cacheControl);
    }
    public function getCacheControlDirective($key)
    {
        return array_key_exists($key, $this->cacheControl) ? $this->cacheControl[$key] : null;
    }
    public function removeCacheControlDirective($key)
    {
        unset($this->cacheControl[$key]);
        $this->set('Cache-Control', $this->getCacheControlHeader());
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->headers);
    }
    public function count()
    {
        return count($this->headers);
    }
    protected function getCacheControlHeader()
    {
        $parts = array();
        ksort($this->cacheControl);
        foreach ($this->cacheControl as $key => $value) {
            if (true === $value) {
                $parts[] = $key;
            } else {
                if (preg_match('#[^a-zA-Z0-9._-]#', $value)) {
                    $value = '"' . $value . '"';
                }
                $parts[] = "{$key}={$value}";
            }
        }
        return implode(', ', $parts);
    }
    protected function parseCacheControl($header)
    {
        $cacheControl = array();
        preg_match_all('#([a-zA-Z][a-zA-Z_-]*)\\s*(?:=(?:"([^"]*)"|([^ \\t",;]*)))?#', $header, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $cacheControl[strtolower($match[1])] = isset($match[3]) ? $match[3] : (isset($match[2]) ? $match[2] : true);
        }
        return $cacheControl;
    }
}
namespace Symfony\Component\HttpFoundation\Session;

use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;
interface SessionInterface
{
    public function start();
    public function getId();
    public function setId($id);
    public function getName();
    public function setName($name);
    public function invalidate($lifetime = null);
    public function migrate($destroy = false, $lifetime = null);
    public function save();
    public function has($name);
    public function get($name, $default = null);
    public function set($name, $value);
    public function all();
    public function replace(array $attributes);
    public function remove($name);
    public function clear();
    public function isStarted();
    public function registerBag(SessionBagInterface $bag);
    public function getBag($name);
    public function getMetadataBag();
}
namespace Symfony\Component\HttpFoundation\Session;

interface SessionBagInterface
{
    public function getName();
    public function initialize(array &$array);
    public function getStorageKey();
    public function clear();
}
namespace Symfony\Component\HttpFoundation\Session\Attribute;

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
interface AttributeBagInterface extends SessionBagInterface
{
    public function has($name);
    public function get($name, $default = null);
    public function set($name, $value);
    public function all();
    public function replace(array $attributes);
    public function remove($name);
}
namespace Symfony\Component\HttpFoundation\Session\Attribute;

class AttributeBag implements AttributeBagInterface, \IteratorAggregate, \Countable
{
    private $name = 'attributes';
    private $storageKey;
    protected $attributes = array();
    public function __construct($storageKey = '_sf2_attributes')
    {
        $this->storageKey = $storageKey;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function initialize(array &$attributes)
    {
        $this->attributes =& $attributes;
    }
    public function getStorageKey()
    {
        return $this->storageKey;
    }
    public function has($name)
    {
        return array_key_exists($name, $this->attributes);
    }
    public function get($name, $default = null)
    {
        return array_key_exists($name, $this->attributes) ? $this->attributes[$name] : $default;
    }
    public function set($name, $value)
    {
        $this->attributes[$name] = $value;
    }
    public function all()
    {
        return $this->attributes;
    }
    public function replace(array $attributes)
    {
        $this->attributes = array();
        foreach ($attributes as $key => $value) {
            $this->set($key, $value);
        }
    }
    public function remove($name)
    {
        $retval = null;
        if (array_key_exists($name, $this->attributes)) {
            $retval = $this->attributes[$name];
            unset($this->attributes[$name]);
        }
        return $retval;
    }
    public function clear()
    {
        $return = $this->attributes;
        $this->attributes = array();
        return $return;
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->attributes);
    }
    public function count()
    {
        return count($this->attributes);
    }
}
namespace Symfony\Component\HttpFoundation\Session\Storage;

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
class MetadataBag implements SessionBagInterface
{
    const CREATED = 'c';
    const UPDATED = 'u';
    const LIFETIME = 'l';
    private $name = '__metadata';
    private $storageKey;
    protected $meta = array(self::CREATED => 0, self::UPDATED => 0, self::LIFETIME => 0);
    private $lastUsed;
    private $updateThreshold;
    public function __construct($storageKey = '_sf2_meta', $updateThreshold = 0)
    {
        $this->storageKey = $storageKey;
        $this->updateThreshold = $updateThreshold;
    }
    public function initialize(array &$array)
    {
        $this->meta =& $array;
        if (isset($array[self::CREATED])) {
            $this->lastUsed = $this->meta[self::UPDATED];
            $timeStamp = time();
            if ($timeStamp - $array[self::UPDATED] >= $this->updateThreshold) {
                $this->meta[self::UPDATED] = $timeStamp;
            }
        } else {
            $this->stampCreated();
        }
    }
    public function getLifetime()
    {
        return $this->meta[self::LIFETIME];
    }
    public function stampNew($lifetime = null)
    {
        $this->stampCreated($lifetime);
    }
    public function getStorageKey()
    {
        return $this->storageKey;
    }
    public function getCreated()
    {
        return $this->meta[self::CREATED];
    }
    public function getLastUsed()
    {
        return $this->lastUsed;
    }
    public function clear()
    {
        
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    private function stampCreated($lifetime = null)
    {
        $timeStamp = time();
        $this->meta[self::CREATED] = $this->meta[self::UPDATED] = $this->lastUsed = $timeStamp;
        $this->meta[self::LIFETIME] = null === $lifetime ? ini_get('session.cookie_lifetime') : $lifetime;
    }
}
namespace Symfony\Component\HttpFoundation;

class AcceptHeaderItem
{
    private $value;
    private $quality = 1.0;
    private $index = 0;
    private $attributes = array();
    public function __construct($value, array $attributes = array())
    {
        $this->value = $value;
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
    }
    public static function fromString($itemValue)
    {
        $bits = preg_split('/\\s*(?:;*("[^"]+");*|;*(\'[^\']+\');*|;+)\\s*/', $itemValue, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $value = array_shift($bits);
        $attributes = array();
        $lastNullAttribute = null;
        foreach ($bits as $bit) {
            if (($start = substr($bit, 0, 1)) === ($end = substr($bit, -1)) && ($start === '"' || $start === '\'')) {
                $attributes[$lastNullAttribute] = substr($bit, 1, -1);
            } elseif ('=' === $end) {
                $lastNullAttribute = $bit = substr($bit, 0, -1);
                $attributes[$bit] = null;
            } else {
                $parts = explode('=', $bit);
                $attributes[$parts[0]] = isset($parts[1]) && strlen($parts[1]) > 0 ? $parts[1] : '';
            }
        }
        return new self(($start = substr($value, 0, 1)) === ($end = substr($value, -1)) && ($start === '"' || $start === '\'') ? substr($value, 1, -1) : $value, $attributes);
    }
    public function __toString()
    {
        $string = $this->value . ($this->quality < 1 ? ';q=' . $this->quality : '');
        if (count($this->attributes) > 0) {
            $string .= ';' . implode(';', array_map(function ($name, $value) {
                return sprintf(preg_match('/[,;=]/', $value) ? '%s="%s"' : '%s=%s', $name, $value);
            }, array_keys($this->attributes), $this->attributes));
        }
        return $string;
    }
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function setQuality($quality)
    {
        $this->quality = $quality;
        return $this;
    }
    public function getQuality()
    {
        return $this->quality;
    }
    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }
    public function getIndex()
    {
        return $this->index;
    }
    public function hasAttribute($name)
    {
        return isset($this->attributes[$name]);
    }
    public function getAttribute($name, $default = null)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : $default;
    }
    public function getAttributes()
    {
        return $this->attributes;
    }
    public function setAttribute($name, $value)
    {
        if ('q' === $name) {
            $this->quality = (double) $value;
        } else {
            $this->attributes[$name] = (string) $value;
        }
        return $this;
    }
}
namespace Symfony\Component\HttpFoundation;

class AcceptHeader
{
    private $items = array();
    private $sorted = true;
    public function __construct(array $items)
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }
    public static function fromString($headerValue)
    {
        $index = 0;
        return new self(array_map(function ($itemValue) use(&$index) {
            $item = AcceptHeaderItem::fromString($itemValue);
            $item->setIndex($index++);
            return $item;
        }, preg_split('/\\s*(?:,*("[^"]+"),*|,*(\'[^\']+\'),*|,+)\\s*/', $headerValue, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE)));
    }
    public function __toString()
    {
        return implode(',', $this->items);
    }
    public function has($value)
    {
        return isset($this->items[$value]);
    }
    public function get($value)
    {
        return isset($this->items[$value]) ? $this->items[$value] : null;
    }
    public function add(AcceptHeaderItem $item)
    {
        $this->items[$item->getValue()] = $item;
        $this->sorted = false;
        return $this;
    }
    public function all()
    {
        $this->sort();
        return $this->items;
    }
    public function filter($pattern)
    {
        return new self(array_filter($this->items, function (AcceptHeaderItem $item) use($pattern) {
            return preg_match($pattern, $item->getValue());
        }));
    }
    public function first()
    {
        $this->sort();
        return !empty($this->items) ? reset($this->items) : null;
    }
    private function sort()
    {
        if (!$this->sorted) {
            uasort($this->items, function ($a, $b) {
                $qA = $a->getQuality();
                $qB = $b->getQuality();
                if ($qA === $qB) {
                    return $a->getIndex() > $b->getIndex() ? 1 : -1;
                }
                return $qA > $qB ? -1 : 1;
            });
            $this->sorted = true;
        }
    }
}
namespace Symfony\Component\Debug;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\Exception\OutOfMemoryException;
if (!defined('ENT_SUBSTITUTE')) {
    define('ENT_SUBSTITUTE', 8);
}
class ExceptionHandler
{
    private $debug;
    private $handler;
    private $caughtBuffer;
    private $caughtLength;
    private $fileLinkFormat;
    public function __construct($debug = true, $fileLinkFormat = null)
    {
        $this->debug = $debug;
        $this->fileLinkFormat = $fileLinkFormat ?: ini_get('xdebug.file_link_format') ?: get_cfg_var('xdebug.file_link_format');
    }
    public static function register($debug = true, $fileLinkFormat = null)
    {
        $handler = new static($debug, $fileLinkFormat = null);
        $prev = set_exception_handler(array($handler, 'handle'));
        if (is_array($prev) && $prev[0] instanceof ErrorHandler) {
            restore_exception_handler();
            $prev[0]->setExceptionHandler(array($handler, 'handle'));
        }
        return $handler;
    }
    public function setHandler($handler)
    {
        if (null !== $handler && !is_callable($handler)) {
            throw new \LogicException('The exception handler must be a valid PHP callable.');
        }
        $old = $this->handler;
        $this->handler = $handler;
        return $old;
    }
    public function setFileLinkFormat($format)
    {
        $old = $this->fileLinkFormat;
        $this->fileLinkFormat = $format;
        return $old;
    }
    public function handle(\Exception $exception)
    {
        if (null === $this->handler || $exception instanceof OutOfMemoryException) {
            $this->failSafeHandle($exception);
            return;
        }
        $caughtLength = $this->caughtLength = 0;
        ob_start(array($this, 'catchOutput'));
        $this->failSafeHandle($exception);
        while (null === $this->caughtBuffer && ob_end_flush()) {
            
        }
        if (isset($this->caughtBuffer[0])) {
            ob_start(array($this, 'cleanOutput'));
            echo $this->caughtBuffer;
            $caughtLength = ob_get_length();
        }
        $this->caughtBuffer = null;
        try {
            call_user_func($this->handler, $exception);
            $this->caughtLength = $caughtLength;
        } catch (\Exception $e) {
            if (!$caughtLength) {
                throw $exception;
            }
        }
    }
    private function failSafeHandle(\Exception $exception)
    {
        if (class_exists('Symfony\\Component\\HttpFoundation\\Response', false)) {
            $response = $this->createResponse($exception);
            $response->sendHeaders();
            $response->sendContent();
        } else {
            $this->sendPhpResponse($exception);
        }
    }
    public function sendPhpResponse($exception)
    {
        if (!$exception instanceof FlattenException) {
            $exception = FlattenException::create($exception);
        }
        if (!headers_sent()) {
            header(sprintf('HTTP/1.0 %s', $exception->getStatusCode()));
            foreach ($exception->getHeaders() as $name => $value) {
                header($name . ': ' . $value, false);
            }
        }
        echo $this->decorate($this->getContent($exception), $this->getStylesheet($exception));
    }
    public function createResponse($exception)
    {
        if (!$exception instanceof FlattenException) {
            $exception = FlattenException::create($exception);
        }
        return new Response($this->decorate($this->getContent($exception), $this->getStylesheet($exception)), $exception->getStatusCode(), $exception->getHeaders());
    }
    public function getContent(FlattenException $exception)
    {
        switch ($exception->getStatusCode()) {
            case 404:
                $title = 'Sorry, the page you are looking for could not be found.';
                break;
            default:
                $title = 'Whoops, looks like something went wrong.';
        }
        $content = '';
        if ($this->debug) {
            try {
                $count = count($exception->getAllPrevious());
                $total = $count + 1;
                foreach ($exception->toArray() as $position => $e) {
                    $ind = $count - $position + 1;
                    $class = $this->formatClass($e['class']);
                    $message = nl2br(self::utf8Htmlize($e['message']));
                    $content .= sprintf('                        <h2 class="block_exception clear_fix">
                            <span class="exception_counter">%d/%d</span>
                            <span class="exception_title">%s%s:</span>
                            <span class="exception_message">%s</span>
                        </h2>
                        <div class="block">
                            <ol class="traces list_exception">', $ind, $total, $class, $this->formatPath($e['trace'][0]['file'], $e['trace'][0]['line']), $message);
                    foreach ($e['trace'] as $trace) {
                        $content .= '       <li>';
                        if ($trace['function']) {
                            $content .= sprintf('at %s%s%s(%s)', $this->formatClass($trace['class']), $trace['type'], $trace['function'], $this->formatArgs($trace['args']));
                        }
                        if (isset($trace['file']) && isset($trace['line'])) {
                            $content .= $this->formatPath($trace['file'], $trace['line']);
                        }
                        $content .= '</li>
';
                    }
                    $content .= '    </ol>
</div>
';
                }
            } catch (\Exception $e) {
                if ($this->debug) {
                    $title = sprintf('Exception thrown when handling an exception (%s: %s)', get_class($exception), $exception->getMessage());
                } else {
                    $title = 'Whoops, looks like something went wrong.';
                }
            }
        }
        return "            <div id=\"sf-resetcontent\" class=\"sf-reset\">\n                <h1>{$title}</h1>\n                {$content}\n            </div>";
    }
    public function getStylesheet(FlattenException $exception)
    {
        return '            .sf-reset { font: 11px Verdana, Arial, sans-serif; color: #333 }
            .sf-reset .clear { clear:both; height:0; font-size:0; line-height:0; }
            .sf-reset .clear_fix:after { display:block; height:0; clear:both; visibility:hidden; }
            .sf-reset .clear_fix { display:inline-block; }
            .sf-reset * html .clear_fix { height:1%; }
            .sf-reset .clear_fix { display:block; }
            .sf-reset, .sf-reset .block { margin: auto }
            .sf-reset abbr { border-bottom: 1px dotted #000; cursor: help; }
            .sf-reset p { font-size:14px; line-height:20px; color:#868686; padding-bottom:20px }
            .sf-reset strong { font-weight:bold; }
            .sf-reset a { color:#6c6159; cursor: default; }
            .sf-reset a img { border:none; }
            .sf-reset a:hover { text-decoration:underline; }
            .sf-reset em { font-style:italic; }
            .sf-reset h1, .sf-reset h2 { font: 20px Georgia, "Times New Roman", Times, serif }
            .sf-reset .exception_counter { background-color: #fff; color: #333; padding: 6px; float: left; margin-right: 10px; float: left; display: block; }
            .sf-reset .exception_title { margin-left: 3em; margin-bottom: 0.7em; display: block; }
            .sf-reset .exception_message { margin-left: 3em; display: block; }
            .sf-reset .traces li { font-size:12px; padding: 2px 4px; list-style-type:decimal; margin-left:20px; }
            .sf-reset .block { background-color:#FFFFFF; padding:10px 28px; margin-bottom:20px;
                -webkit-border-bottom-right-radius: 16px;
                -webkit-border-bottom-left-radius: 16px;
                -moz-border-radius-bottomright: 16px;
                -moz-border-radius-bottomleft: 16px;
                border-bottom-right-radius: 16px;
                border-bottom-left-radius: 16px;
                border-bottom:1px solid #ccc;
                border-right:1px solid #ccc;
                border-left:1px solid #ccc;
            }
            .sf-reset .block_exception { background-color:#ddd; color: #333; padding:20px;
                -webkit-border-top-left-radius: 16px;
                -webkit-border-top-right-radius: 16px;
                -moz-border-radius-topleft: 16px;
                -moz-border-radius-topright: 16px;
                border-top-left-radius: 16px;
                border-top-right-radius: 16px;
                border-top:1px solid #ccc;
                border-right:1px solid #ccc;
                border-left:1px solid #ccc;
                overflow: hidden;
                word-wrap: break-word;
            }
            .sf-reset a { background:none; color:#868686; text-decoration:none; }
            .sf-reset a:hover { background:none; color:#313131; text-decoration:underline; }
            .sf-reset ol { padding: 10px 0; }
            .sf-reset h1 { background-color:#FFFFFF; padding: 15px 28px; margin-bottom: 20px;
                -webkit-border-radius: 10px;
                -moz-border-radius: 10px;
                border-radius: 10px;
                border: 1px solid #ccc;
            }';
    }
    private function decorate($content, $css)
    {
        return "<!DOCTYPE html>\n<html>\n    <head>\n        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>\n        <meta name=\"robots\" content=\"noindex,nofollow\" />\n        <style>\n            /* Copyright (c) 2010, Yahoo! Inc. All rights reserved. Code licensed under the BSD License: http://developer.yahoo.com/yui/license.html */\n            html{color:#000;background:#FFF;}body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote,th,td{margin:0;padding:0;}table{border-collapse:collapse;border-spacing:0;}fieldset,img{border:0;}address,caption,cite,code,dfn,em,strong,th,var{font-style:normal;font-weight:normal;}li{list-style:none;}caption,th{text-align:left;}h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal;}q:before,q:after{content:'';}abbr,acronym{border:0;font-variant:normal;}sup{vertical-align:text-top;}sub{vertical-align:text-bottom;}input,textarea,select{font-family:inherit;font-size:inherit;font-weight:inherit;}input,textarea,select{*font-size:100%;}legend{color:#000;}\n\n            html { background: #eee; padding: 10px }\n            img { border: 0; }\n            #sf-resetcontent { width:970px; margin:0 auto; }\n            {$css}\n        </style>\n    </head>\n    <body>\n        {$content}\n    </body>\n</html>";
    }
    private function formatClass($class)
    {
        $parts = explode('\\', $class);
        return sprintf('<abbr title="%s">%s</abbr>', $class, array_pop($parts));
    }
    private function formatPath($path, $line)
    {
        $path = self::utf8Htmlize($path);
        $file = preg_match('#[^/\\\\]*$#', $path, $file) ? $file[0] : $path;
        if ($linkFormat = $this->fileLinkFormat) {
            $link = str_replace(array('%f', '%l'), array($path, $line), $linkFormat);
            return sprintf(' in <a href="%s" title="Go to source">%s line %d</a>', $link, $file, $line);
        }
        return sprintf(' in <a title="%s line %3$d" ondblclick="var f=this.innerHTML;this.innerHTML=this.title;this.title=f;">%s line %d</a>', $path, $file, $line);
    }
    private function formatArgs(array $args)
    {
        $result = array();
        foreach ($args as $key => $item) {
            if ('object' === $item[0]) {
                $formattedValue = sprintf('<em>object</em>(%s)', $this->formatClass($item[1]));
            } elseif ('array' === $item[0]) {
                $formattedValue = sprintf('<em>array</em>(%s)', is_array($item[1]) ? $this->formatArgs($item[1]) : $item[1]);
            } elseif ('string' === $item[0]) {
                $formattedValue = sprintf('\'%s\'', self::utf8Htmlize($item[1]));
            } elseif ('null' === $item[0]) {
                $formattedValue = '<em>null</em>';
            } elseif ('boolean' === $item[0]) {
                $formattedValue = '<em>' . strtolower(var_export($item[1], true)) . '</em>';
            } elseif ('resource' === $item[0]) {
                $formattedValue = '<em>resource</em>';
            } else {
                $formattedValue = str_replace('
', '', var_export(self::utf8Htmlize((string) $item[1]), true));
            }
            $result[] = is_int($key) ? $formattedValue : sprintf('\'%s\' => %s', $key, $formattedValue);
        }
        return implode(', ', $result);
    }
    protected static function utf8Htmlize($str)
    {
        if (!preg_match('//u', $str) && function_exists('iconv')) {
            set_error_handler('var_dump', 0);
            $charset = ini_get('default_charset');
            if ('UTF-8' === $charset || $str !== @iconv($charset, $charset, $str)) {
                $charset = 'CP1252';
            }
            restore_error_handler();
            $str = iconv($charset, 'UTF-8', $str);
        }
        return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
    public function catchOutput($buffer)
    {
        $this->caughtBuffer = $buffer;
        return '';
    }
    public function cleanOutput($buffer)
    {
        if ($this->caughtLength) {
            $cleanBuffer = substr_replace($buffer, '', 0, $this->caughtLength);
            if (isset($cleanBuffer[0])) {
                $buffer = $cleanBuffer;
            }
        }
        return $buffer;
    }
}
namespace Illuminate\Support;

use ReflectionClass;
abstract class ServiceProvider
{
    protected $app;
    protected $defer = false;
    public function __construct($app)
    {
        $this->app = $app;
    }
    public abstract function register();
    public function package($package, $namespace = null, $path = null)
    {
        $namespace = $this->getPackageNamespace($package, $namespace);
        $path = $path ?: $this->guessPackagePath();
        $config = $path . '/config';
        if ($this->app['files']->isDirectory($config)) {
            $this->app['config']->package($package, $config, $namespace);
        }
        $lang = $path . '/lang';
        if ($this->app['files']->isDirectory($lang)) {
            $this->app['translator']->addNamespace($namespace, $lang);
        }
        $appView = $this->getAppViewPath($package);
        if ($this->app['files']->isDirectory($appView)) {
            $this->app['view']->addNamespace($namespace, $appView);
        }
        $view = $path . '/views';
        if ($this->app['files']->isDirectory($view)) {
            $this->app['view']->addNamespace($namespace, $view);
        }
    }
    public function guessPackagePath()
    {
        $path = (new ReflectionClass($this))->getFileName();
        return realpath(dirname($path) . '/../../');
    }
    protected function getPackageNamespace($package, $namespace)
    {
        if (is_null($namespace)) {
            list($vendor, $namespace) = explode('/', $package);
        }
        return $namespace;
    }
    public function commands($commands)
    {
        $commands = is_array($commands) ? $commands : func_get_args();
        $events = $this->app['events'];
        $events->listen('artisan.start', function ($artisan) use($commands) {
            $artisan->resolveCommands($commands);
        });
    }
    protected function getAppViewPath($package)
    {
        return $this->app['path.base'] . "/resources/views/packages/{$package}";
    }
    public function provides()
    {
        return array();
    }
    public function when()
    {
        return array();
    }
    public function isDeferred()
    {
        return $this->defer;
    }
    public static function compiles()
    {
        return array();
    }
    public function __call($method, $parameters)
    {
        if ($method == 'boot') {
            return;
        }
        throw new \BadMethodCallException("Call to undefined method [{$method}]");
    }
}
namespace Illuminate\Support;

class AggregateServiceProvider extends ServiceProvider
{
    protected $providers = array();
    protected $instances = array();
    public function register()
    {
        $this->instances = array();
        foreach ($this->providers as $provider) {
            $this->instances[] = $this->app->register($provider);
        }
    }
    public function provides()
    {
        $provides = array();
        foreach ($this->providers as $provider) {
            $instance = $this->app->resolveProviderClass($provider);
            $provides = array_merge($provides, $instance->provides());
        }
        return $provides;
    }
}
namespace Illuminate\Exception;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;
use Illuminate\Support\ServiceProvider;
class ExceptionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerDisplayers();
        $this->registerHandler();
    }
    protected function registerDisplayers()
    {
        $this->registerPlainDisplayer();
        $this->registerDebugDisplayer();
    }
    protected function registerHandler()
    {
        $this->app['exception'] = $this->app->share(function ($app) {
            return new Handler($app, $app['exception.plain'], $app['exception.debug']);
        });
    }
    protected function registerPlainDisplayer()
    {
        $this->app['exception.plain'] = $this->app->share(function ($app) {
            if ($app->runningInConsole()) {
                return $app['exception.debug'];
            } else {
                return new PlainDisplayer();
            }
        });
    }
    protected function registerDebugDisplayer()
    {
        $this->registerWhoops();
        $this->app['exception.debug'] = $this->app->share(function ($app) {
            return new WhoopsDisplayer($app['whoops'], $app->runningInConsole());
        });
    }
    protected function registerWhoops()
    {
        $this->registerWhoopsHandler();
        $this->app['whoops'] = $this->app->share(function ($app) {
            with($whoops = new Run())->allowQuit(false);
            $whoops->writeToOutput(false);
            return $whoops->pushHandler($app['whoops.handler']);
        });
    }
    protected function registerWhoopsHandler()
    {
        if ($this->shouldReturnJson()) {
            $this->app['whoops.handler'] = $this->app->share(function () {
                return new JsonResponseHandler();
            });
        } else {
            $this->registerPrettyWhoopsHandler();
        }
    }
    protected function shouldReturnJson()
    {
        return $this->app->runningInConsole() || $this->requestWantsJson();
    }
    protected function requestWantsJson()
    {
        return $this->app['request']->ajax() || $this->app['request']->wantsJson();
    }
    protected function registerPrettyWhoopsHandler()
    {
        $this->app['whoops.handler'] = $this->app->share(function () {
            with($handler = new PrettyPageHandler())->setEditor('sublime');
            return $handler;
        });
    }
}
namespace Illuminate\Routing;

use Illuminate\Support\ServiceProvider;
class RoutingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRouter();
        $this->registerUrlGenerator();
        $this->registerRedirector();
        $this->registerResponseFactory();
    }
    protected function registerRouter()
    {
        $this->app['router'] = $this->app->share(function ($app) {
            return new Router($app['events'], $app);
        });
    }
    protected function registerUrlGenerator()
    {
        $this->app['url'] = $this->app->share(function ($app) {
            $routes = $app['router']->getRoutes();
            $app->instance('routes', $routes);
            $url = new UrlGenerator($routes, $app->rebinding('request', $this->requestRebinder()));
            $app->rebinding('routes', function ($app, $routes) {
                $app['url']->setRoutes($routes);
            });
            return $url;
        });
    }
    protected function requestRebinder()
    {
        return function ($app, $request) {
            $app['url']->setRequest($request);
        };
    }
    protected function registerRedirector()
    {
        $this->app['redirect'] = $this->app->share(function ($app) {
            $redirector = new Redirector($app['url']);
            if (isset($app['session.store'])) {
                $redirector->setSession($app['session.store']);
            }
            return $redirector;
        });
    }
    protected function registerResponseFactory()
    {
        $this->app->bindShared('Illuminate\\Contracts\\Routing\\ResponseFactory', function ($app) {
            return new ResponseFactory($app['Illuminate\\Contracts\\View\\Factory'], $app['redirect']);
        });
    }
}
namespace Illuminate\Events;

use Illuminate\Support\ServiceProvider;
class EventServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['events'] = $this->app->share(function ($app) {
            return new Dispatcher($app);
        });
    }
}
namespace Illuminate\Validation;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
class ValidationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerValiationResolverHook();
        $this->registerPresenceVerifier();
        $this->registerValidationFactory();
    }
    protected function registerValiationResolverHook()
    {
        $this->app->afterResolvingAny(function ($resolved) {
            if ($resolved instanceof ValidatesWhenResolved) {
                $resolved->validate();
            }
        });
    }
    protected function registerValidationFactory()
    {
        $this->app->bindShared('validator', function ($app) {
            $validator = new Factory($app['translator'], $app);
            if (isset($app['validation.presence'])) {
                $validator->setPresenceVerifier($app['validation.presence']);
            }
            return $validator;
        });
    }
    protected function registerPresenceVerifier()
    {
        $this->app->bindShared('validation.presence', function ($app) {
            return new DatabasePresenceVerifier($app['db']);
        });
    }
}
namespace Illuminate\Foundation\Providers;

use Illuminate\Support\AggregateServiceProvider;
class FoundationServiceProvider extends AggregateServiceProvider
{
    protected $providers = array('Illuminate\\Foundation\\Providers\\FormRequestServiceProvider');
}
namespace Illuminate\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;
class FormRequestServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }
    public function boot()
    {
        $this->app['events']->listen('router.matched', function () {
            $this->app->resolvingAny(function ($resolved, $app) {
                if ($resolved instanceof FormRequest) {
                    $this->initializeRequest($resolved, $app['request']);
                    $resolved->setContainer($app)->setRoute($app['Illuminate\\Routing\\Route'])->setRedirector($app['Illuminate\\Routing\\Redirector']);
                }
            });
        });
    }
    protected function initializeRequest(FormRequest $form, Request $current)
    {
        $files = $current->files->all();
        $files = is_array($files) ? array_filter($files) : $files;
        $form->initialize($current->query->all(), $current->request->all(), $current->attributes->all(), $current->cookies->all(), $files, $current->server->all(), $current->getContent());
        $form->setUserResolver($current->getUserResolver());
        $form->setRouteResolver($current->getRouteResolver());
    }
}
namespace Illuminate\Auth;

use Illuminate\Support\ServiceProvider;
class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerAuthenticator();
        $this->registerUserResolver();
        $this->registerRequestRebindHandler();
    }
    protected function registerAuthenticator()
    {
        $this->app->bindShared('auth', function ($app) {
            $app['auth.loaded'] = true;
            return new AuthManager($app);
        });
        $this->app->bindShared('auth.driver', function ($app) {
            return $app['auth']->driver();
        });
    }
    protected function registerUserResolver()
    {
        $this->app->bind('Illuminate\\Contracts\\Auth\\User', function ($app) {
            return $app['auth']->user();
        });
    }
    protected function registerRequestRebindHandler()
    {
        $this->app->rebinding('request', function ($app, $request) {
            $request->setUserResolver(function () use($app) {
                return $app['auth']->user();
            });
        });
    }
}
namespace Illuminate\Pagination;

use Illuminate\Support\ServiceProvider;
class PaginationServiceProvider extends ServiceProvider
{
    public function register()
    {
        Paginator::currentPathResolver(function () {
            return $this->app['request']->url();
        });
        Paginator::currentPageResolver(function () {
            return $this->app['request']->input('page');
        });
    }
}
namespace Illuminate\Support\Facades;

use Mockery\MockInterface;
abstract class Facade
{
    protected static $app;
    protected static $resolvedInstance;
    public static function swap($instance)
    {
        static::$resolvedInstance[static::getFacadeAccessor()] = $instance;
        static::$app->instance(static::getFacadeAccessor(), $instance);
    }
    public static function shouldReceive()
    {
        $name = static::getFacadeAccessor();
        if (static::isMock()) {
            $mock = static::$resolvedInstance[$name];
        } else {
            $mock = static::createFreshMockInstance($name);
        }
        return call_user_func_array(array($mock, 'shouldReceive'), func_get_args());
    }
    protected static function createFreshMockInstance($name)
    {
        static::$resolvedInstance[$name] = $mock = static::createMockByName($name);
        if (isset(static::$app)) {
            static::$app->instance($name, $mock);
        }
        return $mock;
    }
    protected static function createMockByName($name)
    {
        $class = static::getMockableClass($name);
        return $class ? \Mockery::mock($class) : \Mockery::mock();
    }
    protected static function isMock()
    {
        $name = static::getFacadeAccessor();
        return isset(static::$resolvedInstance[$name]) && static::$resolvedInstance[$name] instanceof MockInterface;
    }
    protected static function getMockableClass()
    {
        if ($root = static::getFacadeRoot()) {
            return get_class($root);
        }
    }
    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }
    protected static function getFacadeAccessor()
    {
        throw new \RuntimeException('Facade does not implement getFacadeAccessor method.');
    }
    protected static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }
        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }
        return static::$resolvedInstance[$name] = static::$app[$name];
    }
    public static function clearResolvedInstance($name)
    {
        unset(static::$resolvedInstance[$name]);
    }
    public static function clearResolvedInstances()
    {
        static::$resolvedInstance = array();
    }
    public static function getFacadeApplication()
    {
        return static::$app;
    }
    public static function setFacadeApplication($app)
    {
        static::$app = $app;
    }
    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();
        switch (count($args)) {
            case 0:
                return $instance->{$method}();
            case 1:
                return $instance->{$method}($args[0]);
            case 2:
                return $instance->{$method}($args[0], $args[1]);
            case 3:
                return $instance->{$method}($args[0], $args[1], $args[2]);
            case 4:
                return $instance->{$method}($args[0], $args[1], $args[2], $args[3]);
            default:
                return call_user_func_array(array($instance, $method), $args);
        }
    }
}
namespace Illuminate\Support\Traits;

trait MacroableTrait
{
    protected static $macros = array();
    public static function macro($name, callable $macro)
    {
        static::$macros[$name] = $macro;
    }
    public static function hasMacro($name)
    {
        return isset(static::$macros[$name]);
    }
    public static function __callStatic($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return call_user_func_array(static::$macros[$method], $parameters);
        }
        throw new \BadMethodCallException("Method {$method} does not exist.");
    }
    public function __call($method, $parameters)
    {
        return static::__callStatic($method, $parameters);
    }
}
namespace Illuminate\Support;

use Closure;
use Illuminate\Support\Traits\MacroableTrait;
class Arr
{
    use MacroableTrait;
    public static function add($array, $key, $value)
    {
        if (is_null(static::get($array, $key))) {
            static::set($array, $key, $value);
        }
        return $array;
    }
    public static function build($array, Closure $callback)
    {
        $results = array();
        foreach ($array as $key => $value) {
            list($innerKey, $innerValue) = call_user_func($callback, $key, $value);
            $results[$innerKey] = $innerValue;
        }
        return $results;
    }
    public static function divide($array)
    {
        return array(array_keys($array), array_values($array));
    }
    public static function dot($array, $prepend = '')
    {
        $results = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }
        return $results;
    }
    public static function except($array, $keys)
    {
        return array_diff_key($array, array_flip((array) $keys));
    }
    public static function fetch($array, $key)
    {
        foreach (explode('.', $key) as $segment) {
            $results = array();
            foreach ($array as $value) {
                $value = (array) $value;
                $results[] = $value[$segment];
            }
            $array = array_values($results);
        }
        return array_values($results);
    }
    public static function first($array, $callback, $default = null)
    {
        foreach ($array as $key => $value) {
            if (call_user_func($callback, $key, $value)) {
                return $value;
            }
        }
        return value($default);
    }
    public static function last($array, $callback, $default = null)
    {
        return static::first(array_reverse($array), $callback, $default);
    }
    public static function flatten($array)
    {
        $return = array();
        array_walk_recursive($array, function ($x) use(&$return) {
            $return[] = $x;
        });
        return $return;
    }
    public static function forget(&$array, $keys)
    {
        $original =& $array;
        foreach ((array) $keys as $key) {
            $parts = explode('.', $key);
            while (count($parts) > 1) {
                $part = array_shift($parts);
                if (isset($array[$part]) && is_array($array[$part])) {
                    $array =& $array[$part];
                }
            }
            unset($array[array_shift($parts)]);
            $array =& $original;
        }
    }
    public static function get($array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }
        if (isset($array[$key])) {
            return $array[$key];
        }
        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return value($default);
            }
            $array = $array[$segment];
        }
        return $array;
    }
    public static function only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }
    public static function pluck($array, $value, $key = null)
    {
        $results = array();
        foreach ($array as $item) {
            $itemValue = is_object($item) ? $item->{$value} : $item[$value];
            if (is_null($key)) {
                $results[] = $itemValue;
            } else {
                $itemKey = is_object($item) ? $item->{$key} : $item[$key];
                $results[$itemKey] = $itemValue;
            }
        }
        return $results;
    }
    public static function pull(&$array, $key, $default = null)
    {
        $value = static::get($array, $key, $default);
        static::forget($array, $key);
        return $value;
    }
    public static function set(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }
        $keys = explode('.', $key);
        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = array();
            }
            $array =& $array[$key];
        }
        $array[array_shift($keys)] = $value;
        return $array;
    }
    public static function sort($array, Closure $callback)
    {
        return Collection::make($array)->sortBy($callback)->all();
    }
    public static function where($array, Closure $callback)
    {
        $filtered = array();
        foreach ($array as $key => $value) {
            if (call_user_func($callback, $key, $value)) {
                $filtered[$key] = $value;
            }
        }
        return $filtered;
    }
}
namespace Illuminate\Support;

use Patchwork\Utf8;
use Illuminate\Support\Traits\MacroableTrait;
class Str
{
    use MacroableTrait;
    public static function ascii($value)
    {
        return Utf8::toAscii($value);
    }
    public static function camel($value)
    {
        return lcfirst(static::studly($value));
    }
    public static function contains($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && strpos($haystack, $needle) !== false) {
                return true;
            }
        }
        return false;
    }
    public static function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle === substr($haystack, -strlen($needle))) {
                return true;
            }
        }
        return false;
    }
    public static function finish($value, $cap)
    {
        $quoted = preg_quote($cap, '/');
        return preg_replace('/(?:' . $quoted . ')+$/', '', $value) . $cap;
    }
    public static function is($pattern, $value)
    {
        if ($pattern == $value) {
            return true;
        }
        $pattern = preg_quote($pattern, '#');
        $pattern = str_replace('\\*', '.*', $pattern) . '\\z';
        return (bool) preg_match('#^' . $pattern . '#', $value);
    }
    public static function length($value)
    {
        return mb_strlen($value);
    }
    public static function limit($value, $limit = 100, $end = '...')
    {
        if (mb_strlen($value) <= $limit) {
            return $value;
        }
        return rtrim(mb_substr($value, 0, $limit, 'UTF-8')) . $end;
    }
    public static function lower($value)
    {
        return mb_strtolower($value);
    }
    public static function words($value, $words = 100, $end = '...')
    {
        preg_match('/^\\s*+(?:\\S++\\s*+){1,' . $words . '}/u', $value, $matches);
        if (!isset($matches[0]) || strlen($value) === strlen($matches[0])) {
            return $value;
        }
        return rtrim($matches[0]) . $end;
    }
    public static function parseCallback($callback, $default)
    {
        return static::contains($callback, '@') ? explode('@', $callback, 2) : array($callback, $default);
    }
    public static function plural($value, $count = 2)
    {
        return Pluralizer::plural($value, $count);
    }
    public static function random($length = 16)
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length * 2);
            if ($bytes === false) {
                throw new \RuntimeException('Unable to generate random string.');
            }
            return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
        }
        return static::quickRandom($length);
    }
    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
    public static function upper($value)
    {
        return mb_strtoupper($value);
    }
    public static function title($value)
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }
    public static function singular($value)
    {
        return Pluralizer::singular($value);
    }
    public static function slug($title, $separator = '-')
    {
        $title = static::ascii($title);
        $flip = $separator == '-' ? '_' : '-';
        $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);
        $title = preg_replace('![^' . preg_quote($separator) . '\\pL\\pN\\s]+!u', '', mb_strtolower($title));
        $title = preg_replace('![' . preg_quote($separator) . '\\s]+!u', $separator, $title);
        return trim($title, $separator);
    }
    public static function snake($value, $delimiter = '_')
    {
        if (ctype_lower($value)) {
            return $value;
        }
        $replace = '$1' . $delimiter . '$2';
        return strtolower(preg_replace('/(.)([A-Z])/', $replace, $value));
    }
    public static function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && strpos($haystack, $needle) === 0) {
                return true;
            }
        }
        return false;
    }
    public static function studly($value)
    {
        $value = ucwords(str_replace(array('-', '_'), ' ', $value));
        return str_replace(' ', '', $value);
    }
}
namespace Symfony\Component\Debug;

use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Debug\Exception\ContextErrorException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Debug\Exception\OutOfMemoryException;
use Symfony\Component\Debug\FatalErrorHandler\UndefinedFunctionFatalErrorHandler;
use Symfony\Component\Debug\FatalErrorHandler\UndefinedMethodFatalErrorHandler;
use Symfony\Component\Debug\FatalErrorHandler\ClassNotFoundFatalErrorHandler;
use Symfony\Component\Debug\FatalErrorHandler\FatalErrorHandlerInterface;
class ErrorHandler
{
    const TYPE_DEPRECATION = -100;
    private $levels = array(E_DEPRECATED => 'Deprecated', E_USER_DEPRECATED => 'User Deprecated', E_NOTICE => 'Notice', E_USER_NOTICE => 'User Notice', E_STRICT => 'Runtime Notice', E_WARNING => 'Warning', E_USER_WARNING => 'User Warning', E_COMPILE_WARNING => 'Compile Warning', E_CORE_WARNING => 'Core Warning', E_USER_ERROR => 'User Error', E_RECOVERABLE_ERROR => 'Catchable Fatal Error', E_COMPILE_ERROR => 'Compile Error', E_PARSE => 'Parse Error', E_ERROR => 'Error', E_CORE_ERROR => 'Core Error');
    private $loggers = array(E_DEPRECATED => array(null, LogLevel::INFO), E_USER_DEPRECATED => array(null, LogLevel::INFO), E_NOTICE => array(null, LogLevel::NOTICE), E_USER_NOTICE => array(null, LogLevel::NOTICE), E_STRICT => array(null, LogLevel::NOTICE), E_WARNING => array(null, LogLevel::WARNING), E_USER_WARNING => array(null, LogLevel::WARNING), E_COMPILE_WARNING => array(null, LogLevel::WARNING), E_CORE_WARNING => array(null, LogLevel::WARNING), E_USER_ERROR => array(null, LogLevel::ERROR), E_RECOVERABLE_ERROR => array(null, LogLevel::ERROR), E_COMPILE_ERROR => array(null, LogLevel::EMERGENCY), E_PARSE => array(null, LogLevel::EMERGENCY), E_ERROR => array(null, LogLevel::EMERGENCY), E_CORE_ERROR => array(null, LogLevel::EMERGENCY));
    private $thrownErrors = 8191;
    private $scopedErrors = 8191;
    private $tracedErrors = 30715;
    private $screamedErrors = 85;
    private $loggedErrors = 0;
    private $loggedTraces = array();
    private $isRecursive = 0;
    private $exceptionHandler;
    private static $reservedMemory;
    private static $stackedErrors = array();
    private static $stackedErrorLevels = array();
    private $displayErrors = 8191;
    public static function register($levels = -1, $throw = true)
    {
        if (null === self::$reservedMemory) {
            self::$reservedMemory = str_repeat('x', 10240);
            register_shutdown_function(__CLASS__ . '::handleFatalError');
        }
        $handler = new static();
        $levels &= $handler->thrownErrors;
        $prev = set_error_handler(array($handler, 'handleError'), $levels);
        $prev = is_array($prev) ? $prev[0] : null;
        if ($prev instanceof self) {
            restore_error_handler();
            $handler = $prev;
        } else {
            $handler->setExceptionHandler(set_exception_handler(array($handler, 'handleException')));
        }
        $handler->throwAt($throw ? $levels : 0, true);
        return $handler;
    }
    public function setDefaultLogger(LoggerInterface $logger, $levels = null, $replace = false)
    {
        $loggers = array();
        if (is_array($levels)) {
            foreach ($levels as $type => $logLevel) {
                if (empty($this->loggers[$type][0]) || $replace) {
                    $loggers[$type] = array($logger, $logLevel);
                }
            }
        } else {
            if (null === $levels) {
                $levels = E_ALL | E_STRICT;
            }
            foreach ($this->loggers as $type => $log) {
                if ($type & $levels && (empty($log[0]) || $replace)) {
                    $log[0] = $logger;
                    $loggers[$type] = $log;
                }
            }
        }
        $this->setLoggers($loggers);
    }
    public function setLoggers(array $loggers)
    {
        $prevLogged = $this->loggedErrors;
        $prev = $this->loggers;
        foreach ($loggers as $type => $log) {
            if (!isset($prev[$type])) {
                throw new \InvalidArgumentException('Unknown error type: ' . $type);
            }
            if (!is_array($log)) {
                $log = array($log);
            } elseif (!array_key_exists(0, $log)) {
                throw new \InvalidArgumentException('No logger provided');
            }
            if (null === $log[0]) {
                $this->loggedErrors &= ~$type;
            } elseif ($log[0] instanceof LoggerInterface) {
                $this->loggedErrors |= $type;
            } else {
                throw new \InvalidArgumentException('Invalid logger provided');
            }
            $this->loggers[$type] = $log + $prev[$type];
        }
        $this->reRegister($prevLogged | $this->thrownErrors);
        return $prev;
    }
    public function setExceptionHandler($handler)
    {
        if (null !== $handler && !is_callable($handler)) {
            throw new \LogicException('The exception handler must be a valid PHP callable.');
        }
        $prev = $this->exceptionHandler;
        $this->exceptionHandler = $handler;
        return $prev;
    }
    public function throwAt($levels, $replace = false)
    {
        $prev = $this->thrownErrors;
        $this->thrownErrors = ($levels | E_RECOVERABLE_ERROR | E_USER_ERROR) & ~E_USER_DEPRECATED & ~E_DEPRECATED;
        if (!$replace) {
            $this->thrownErrors |= $prev;
        }
        $this->reRegister($prev | $this->loggedErrors);
        $this->displayErrors = $this->thrownErrors;
        return $prev;
    }
    public function scopeAt($levels, $replace = false)
    {
        $prev = $this->scopedErrors;
        $this->scopedErrors = (int) $levels;
        if (!$replace) {
            $this->scopedErrors |= $prev;
        }
        return $prev;
    }
    public function traceAt($levels, $replace = false)
    {
        $prev = $this->tracedErrors;
        $this->tracedErrors = (int) $levels;
        if (!$replace) {
            $this->tracedErrors |= $prev;
        }
        return $prev;
    }
    public function screamAt($levels, $replace = false)
    {
        $prev = $this->screamedErrors;
        $this->screamedErrors = (int) $levels;
        if (!$replace) {
            $this->screamedErrors |= $prev;
        }
        return $prev;
    }
    private function reRegister($prev)
    {
        if ($prev !== $this->thrownErrors | $this->loggedErrors) {
            $handler = set_error_handler('var_dump', 0);
            $handler = is_array($handler) ? $handler[0] : null;
            restore_error_handler();
            if ($handler === $this) {
                restore_error_handler();
                set_error_handler(array($this, 'handleError'), $this->thrownErrors | $this->loggedErrors);
            }
        }
    }
    public function handleError($type, $message, $file, $line, array $context)
    {
        $level = error_reporting() | E_RECOVERABLE_ERROR | E_USER_ERROR;
        $log = $this->loggedErrors & $type;
        $throw = $this->thrownErrors & $type & $level;
        $type &= $level | $this->screamedErrors;
        if ($type && ($log || $throw)) {
            if (PHP_VERSION_ID < 50400 && isset($context['GLOBALS']) && $this->scopedErrors & $type) {
                $e = $context;
                unset($e['GLOBALS'], $context);
                $context = $e;
            }
            if ($throw) {
                if ($this->scopedErrors & $type && class_exists('Symfony\\Component\\Debug\\Exception\\ContextErrorException')) {
                    $throw = new ContextErrorException($this->levels[$type] . ': ' . $message, 0, $type, $file, $line, $context);
                } else {
                    $throw = new \ErrorException($this->levels[$type] . ': ' . $message, 0, $type, $file, $line);
                }
                if (PHP_VERSION_ID <= 50407 && (PHP_VERSION_ID >= 50400 || PHP_VERSION_ID <= 50317)) {
                    $throw->errorHandlerCanary = new ErrorHandlerCanary();
                }
                throw $throw;
            }
            $e = md5("{$type}/{$line}/{$file} {$message}", true);
            $trace = true;
            if (!($this->tracedErrors & $type) || isset($this->loggedTraces[$e])) {
                $trace = false;
            } else {
                $this->loggedTraces[$e] = 1;
            }
            $e = compact('type', 'file', 'line', 'level');
            if ($type & $level) {
                if ($this->scopedErrors & $type) {
                    $e['context'] = $context;
                    if ($trace) {
                        $e['stack'] = debug_backtrace(true);
                    }
                } elseif ($trace) {
                    $e['stack'] = debug_backtrace(PHP_VERSION_ID >= 50306 ? DEBUG_BACKTRACE_IGNORE_ARGS : false);
                }
            }
            if ($this->isRecursive) {
                $log = 0;
            } elseif (self::$stackedErrorLevels) {
                self::$stackedErrors[] = array($this->loggers[$type], $message, $e);
            } else {
                try {
                    $this->isRecursive = true;
                    $this->loggers[$type][0]->log($this->loggers[$type][1], $message, $e);
                    $this->isRecursive = false;
                } catch (\Exception $e) {
                    $this->isRecursive = false;
                    throw $e;
                }
            }
        }
        return $type && $log;
    }
    public function handleException(\Exception $exception, array $error = null)
    {
        $level = error_reporting();
        if ($this->loggedErrors & E_ERROR & ($level | $this->screamedErrors)) {
            $e = array('type' => E_ERROR, 'file' => $exception->getFile(), 'line' => $exception->getLine(), 'level' => $level, 'stack' => $exception->getTrace());
            if ($exception instanceof FatalErrorException) {
                $message = 'Fatal ' . $exception->getMessage();
            } elseif ($exception instanceof \ErrorException) {
                $message = 'Uncaught ' . $exception->getMessage();
                if ($exception instanceof ContextErrorException) {
                    $e['context'] = $exception->getContext();
                }
            } else {
                $message = 'Uncaught Exception: ' . $exception->getMessage();
            }
            if ($this->loggedErrors & $e['type']) {
                $this->loggers[$e['type']][0]->log($this->loggers[$e['type']][1], $message, $e);
            }
        }
        if ($exception instanceof FatalErrorException && !$exception instanceof OutOfMemoryException && $error) {
            foreach ($this->getFatalErrorHandlers() as $handler) {
                if ($e = $handler->handleError($error, $exception)) {
                    $exception = $e;
                    break;
                }
            }
        }
        if (empty($this->exceptionHandler)) {
            throw $exception;
        }
        try {
            call_user_func($this->exceptionHandler, $exception);
        } catch (\Exception $handlerException) {
            $this->exceptionHandler = null;
            $this->handleException($handlerException);
        }
    }
    public static function handleFatalError(array $error = null)
    {
        self::$reservedMemory = '';
        gc_collect_cycles();
        $handler = set_error_handler('var_dump', 0);
        $handler = is_array($handler) ? $handler[0] : null;
        restore_error_handler();
        if ($handler instanceof self) {
            if (null === $error) {
                $error = error_get_last();
            }
            try {
                while (self::$stackedErrorLevels) {
                    static::unstackErrors();
                }
            } catch (\Exception $exception) {
                
            }
            if ($error && $error['type'] & (E_PARSE | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR)) {
                $handler->throwAt(0, true);
                if (0 === strpos($error['message'], 'Allowed memory') || 0 === strpos($error['message'], 'Out of memory')) {
                    $exception = new OutOfMemoryException($handler->levels[$error['type']] . ': ' . $error['message'], 0, $error['type'], $error['file'], $error['line'], 2, false);
                } else {
                    $exception = new FatalErrorException($handler->levels[$error['type']] . ': ' . $error['message'], 0, $error['type'], $error['file'], $error['line'], 2, true);
                }
            } elseif (!isset($exception)) {
                return;
            }
            try {
                $handler->handleException($exception, $error);
            } catch (FatalErrorException $e) {
                
            }
        }
    }
    public static function stackErrors()
    {
        self::$stackedErrorLevels[] = error_reporting(error_reporting() | E_PARSE | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR);
    }
    public static function unstackErrors()
    {
        $level = array_pop(self::$stackedErrorLevels);
        if (null !== $level) {
            $e = error_reporting($level);
            if ($e !== ($level | E_PARSE | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR)) {
                error_reporting($e);
            }
        }
        if (empty(self::$stackedErrorLevels)) {
            $errors = self::$stackedErrors;
            self::$stackedErrors = array();
            foreach ($errors as $e) {
                $e[0][0]->log($e[0][1], $e[1], $e[2]);
            }
        }
    }
    protected function getFatalErrorHandlers()
    {
        return array(new UndefinedFunctionFatalErrorHandler(), new UndefinedMethodFatalErrorHandler(), new ClassNotFoundFatalErrorHandler());
    }
    public function setLevel($level)
    {
        $level = null === $level ? error_reporting() : $level;
        $this->throwAt($level, true);
    }
    public function setDisplayErrors($displayErrors)
    {
        if ($displayErrors) {
            $this->throwAt($this->displayErrors, true);
        } else {
            $displayErrors = $this->displayErrors;
            $this->throwAt(0, true);
            $this->displayErrors = $displayErrors;
        }
    }
    public static function setLogger(LoggerInterface $logger, $channel = 'deprecation')
    {
        $handler = set_error_handler('var_dump', 0);
        $handler = is_array($handler) ? $handler[0] : null;
        restore_error_handler();
        if (!$handler instanceof self) {
            return;
        }
        if ('deprecation' === $channel) {
            $handler->setDefaultLogger($logger, E_DEPRECATED | E_USER_DEPRECATED, true);
            $handler->screamAt(E_DEPRECATED | E_USER_DEPRECATED);
        } elseif ('scream' === $channel) {
            $handler->setDefaultLogger($logger, E_ALL | E_STRICT, false);
            $handler->screamAt(E_ALL | E_STRICT);
        } elseif ('emergency' === $channel) {
            $handler->setDefaultLogger($logger, E_PARSE | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR, true);
            $handler->screamAt(E_PARSE | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR);
        }
    }
    public function handle($level, $message, $file = 'unknown', $line = 0, $context = array())
    {
        return $this->handleError($level, $message, $file, $line, (array) $context);
    }
    public function handleFatal()
    {
        static::handleFatalError();
    }
}
class ErrorHandlerCanary
{
    private static $displayErrors = null;
    public function __construct()
    {
        if (null === self::$displayErrors) {
            self::$displayErrors = ini_set('display_errors', 1);
        }
    }
    public function __destruct()
    {
        if (null !== self::$displayErrors) {
            ini_set('display_errors', self::$displayErrors);
            self::$displayErrors = null;
        }
    }
}
namespace Symfony\Component\HttpKernel\Debug;

use Symfony\Component\Debug\ErrorHandler as DebugErrorHandler;
class ErrorHandler extends DebugErrorHandler
{
    
}
namespace Illuminate\Config;

use Closure;
use ArrayAccess;
use Illuminate\Support\NamespacedItemResolver;
use Illuminate\Contracts\Config\Repository as ConfigContract;
class Repository extends NamespacedItemResolver implements ArrayAccess, ConfigContract
{
    protected $loader;
    protected $environment;
    protected $items = array();
    protected $packages = array();
    protected $afterLoad = array();
    public function __construct(LoaderInterface $loader, $environment)
    {
        $this->loader = $loader;
        $this->environment = $environment;
    }
    public function has($key)
    {
        $default = microtime(true);
        return $this->get($key, $default) !== $default;
    }
    public function hasGroup($key)
    {
        list($namespace, $group, $item) = $this->parseKey($key);
        return $this->loader->exists($group, $namespace);
    }
    public function get($key, $default = null)
    {
        list($namespace, $group, $item) = $this->parseKey($key);
        $collection = $this->getCollection($group, $namespace);
        $this->load($group, $namespace, $collection);
        return array_get($this->items[$collection], $item, $default);
    }
    public function set($key, $value)
    {
        list($namespace, $group, $item) = $this->parseKey($key);
        $collection = $this->getCollection($group, $namespace);
        $this->load($group, $namespace, $collection);
        if (is_null($item)) {
            $this->items[$collection] = $value;
        } else {
            array_set($this->items[$collection], $item, $value);
        }
    }
    protected function load($group, $namespace, $collection)
    {
        $env = $this->environment;
        if (isset($this->items[$collection])) {
            return;
        }
        $items = $this->loader->load($env, $group, $namespace);
        if (isset($this->afterLoad[$namespace])) {
            $items = $this->callAfterLoad($namespace, $group, $items);
        }
        $this->items[$collection] = $items;
    }
    protected function callAfterLoad($namespace, $group, $items)
    {
        $callback = $this->afterLoad[$namespace];
        return call_user_func($callback, $this, $group, $items);
    }
    protected function parseNamespacedSegments($key)
    {
        list($namespace, $item) = explode('::', $key);
        if (in_array($namespace, $this->packages)) {
            return $this->parsePackageSegments($key, $namespace, $item);
        }
        return parent::parseNamespacedSegments($key);
    }
    protected function parsePackageSegments($key, $namespace, $item)
    {
        $itemSegments = explode('.', $item);
        if (!$this->loader->exists($itemSegments[0], $namespace)) {
            return array($namespace, 'config', $item);
        }
        return parent::parseNamespacedSegments($key);
    }
    public function package($package, $hint, $namespace = null)
    {
        $namespace = $this->getPackageNamespace($package, $namespace);
        $this->packages[] = $namespace;
        $this->addNamespace($namespace, $hint);
        $this->afterLoading($namespace, function ($me, $group, $items) use($package) {
            $env = $me->getEnvironment();
            $loader = $me->getLoader();
            return $loader->cascadePackage($env, $package, $group, $items);
        });
    }
    protected function getPackageNamespace($package, $namespace)
    {
        if (is_null($namespace)) {
            list($vendor, $namespace) = explode('/', $package);
        }
        return $namespace;
    }
    public function afterLoading($namespace, Closure $callback)
    {
        $this->afterLoad[$namespace] = $callback;
    }
    protected function getCollection($group, $namespace = null)
    {
        $namespace = $namespace ?: '*';
        return $namespace . '::' . $group;
    }
    public function addNamespace($namespace, $hint)
    {
        $this->loader->addNamespace($namespace, $hint);
    }
    public function getNamespaces()
    {
        return $this->loader->getNamespaces();
    }
    public function getLoader()
    {
        return $this->loader;
    }
    public function setLoader(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }
    public function getEnvironment()
    {
        return $this->environment;
    }
    public function getAfterLoadCallbacks()
    {
        return $this->afterLoad;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function offsetExists($key)
    {
        return $this->has($key);
    }
    public function offsetGet($key)
    {
        return $this->get($key);
    }
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }
    public function offsetUnset($key)
    {
        $this->set($key, null);
    }
}
namespace Illuminate\Support;

class NamespacedItemResolver
{
    protected $parsed = array();
    public function parseKey($key)
    {
        if (isset($this->parsed[$key])) {
            return $this->parsed[$key];
        }
        if (strpos($key, '::') === false) {
            $segments = explode('.', $key);
            $parsed = $this->parseBasicSegments($segments);
        } else {
            $parsed = $this->parseNamespacedSegments($key);
        }
        return $this->parsed[$key] = $parsed;
    }
    protected function parseBasicSegments(array $segments)
    {
        $group = $segments[0];
        if (count($segments) == 1) {
            return array(null, $group, null);
        } else {
            $item = implode('.', array_slice($segments, 1));
            return array(null, $group, $item);
        }
    }
    protected function parseNamespacedSegments($key)
    {
        list($namespace, $item) = explode('::', $key);
        $itemSegments = explode('.', $item);
        $groupAndItem = array_slice($this->parseBasicSegments($itemSegments), 1);
        return array_merge(array($namespace), $groupAndItem);
    }
    public function setParsedKey($key, $parsed)
    {
        $this->parsed[$key] = $parsed;
    }
}
namespace Illuminate\Config;

use Illuminate\Filesystem\Filesystem;
class FileLoader implements LoaderInterface
{
    protected $files;
    protected $defaultPath;
    protected $hints = array();
    protected $exists = array();
    public function __construct(Filesystem $files, $defaultPath)
    {
        $this->files = $files;
        $this->defaultPath = $defaultPath;
    }
    public function load($environment, $group, $namespace = null)
    {
        $items = array();
        $path = $this->getPath($namespace);
        if (is_null($path)) {
            return $items;
        }
        $file = "{$path}/{$group}.php";
        if ($this->files->exists($file)) {
            $items = $this->files->getRequire($file);
        }
        $file = "{$path}/{$environment}/{$group}.php";
        if ($this->files->exists($file)) {
            $items = $this->mergeEnvironment($items, $file);
        }
        return $items;
    }
    protected function mergeEnvironment(array $items, $file)
    {
        return config_merge($items, $this->files->getRequire($file));
    }
    public function exists($group, $namespace = null)
    {
        $key = $group . $namespace;
        if (isset($this->exists[$key])) {
            return $this->exists[$key];
        }
        $path = $this->getPath($namespace);
        if (is_null($path)) {
            return $this->exists[$key] = false;
        }
        $file = "{$path}/{$group}.php";
        $exists = $this->files->exists($file);
        return $this->exists[$key] = $exists;
    }
    public function cascadePackage($env, $package, $group, $items)
    {
        $file = "packages/{$package}/{$group}.php";
        if ($this->files->exists($path = $this->defaultPath . '/' . $file)) {
            $items = config_merge($items, $this->getRequire($path));
        }
        $path = $this->getPackagePath($env, $package, $group);
        if ($this->files->exists($path)) {
            $items = config_merge($items, $this->getRequire($path));
        }
        return $items;
    }
    protected function getPackagePath($env, $package, $group)
    {
        $file = "packages/{$package}/{$env}/{$group}.php";
        return $this->defaultPath . '/' . $file;
    }
    protected function getPath($namespace)
    {
        if (is_null($namespace)) {
            return $this->defaultPath;
        } elseif (isset($this->hints[$namespace])) {
            return $this->hints[$namespace];
        }
    }
    public function addNamespace($namespace, $hint)
    {
        $this->hints[$namespace] = $hint;
    }
    public function getNamespaces()
    {
        return $this->hints;
    }
    protected function getRequire($path)
    {
        return $this->files->getRequire($path);
    }
    public function getFilesystem()
    {
        return $this->files;
    }
}
namespace Illuminate\Config;

interface LoaderInterface
{
    public function load($environment, $group, $namespace = null);
    public function exists($group, $namespace = null);
    public function addNamespace($namespace, $hint);
    public function getNamespaces();
    public function cascadePackage($environment, $package, $group, $items);
}
namespace Illuminate\Filesystem;

use FilesystemIterator;
use Symfony\Component\Finder\Finder;
class Filesystem
{
    public function exists($path)
    {
        return file_exists($path);
    }
    public function get($path)
    {
        if ($this->isFile($path)) {
            return file_get_contents($path);
        }
        throw new FileNotFoundException("File does not exist at path {$path}");
    }
    public function getRequire($path)
    {
        if ($this->isFile($path)) {
            return require $path;
        }
        throw new FileNotFoundException("File does not exist at path {$path}");
    }
    public function requireOnce($file)
    {
        require_once $file;
    }
    public function put($path, $contents)
    {
        return file_put_contents($path, $contents);
    }
    public function prepend($path, $data)
    {
        if ($this->exists($path)) {
            return $this->put($path, $data . $this->get($path));
        }
        return $this->put($path, $data);
    }
    public function append($path, $data)
    {
        return file_put_contents($path, $data, FILE_APPEND);
    }
    public function delete($paths)
    {
        $paths = is_array($paths) ? $paths : func_get_args();
        $success = true;
        foreach ($paths as $path) {
            if (!@unlink($path)) {
                $success = false;
            }
        }
        return $success;
    }
    public function move($path, $target)
    {
        return rename($path, $target);
    }
    public function copy($path, $target)
    {
        return copy($path, $target);
    }
    public function extension($path)
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }
    public function type($path)
    {
        return filetype($path);
    }
    public function size($path)
    {
        return filesize($path);
    }
    public function lastModified($path)
    {
        return filemtime($path);
    }
    public function isDirectory($directory)
    {
        return is_dir($directory);
    }
    public function isWritable($path)
    {
        return is_writable($path);
    }
    public function isFile($file)
    {
        return is_file($file);
    }
    public function glob($pattern, $flags = 0)
    {
        return glob($pattern, $flags);
    }
    public function files($directory)
    {
        $glob = glob($directory . '/*');
        if ($glob === false) {
            return array();
        }
        return array_filter($glob, function ($file) {
            return filetype($file) == 'file';
        });
    }
    public function allFiles($directory)
    {
        return iterator_to_array(Finder::create()->files()->in($directory), false);
    }
    public function directories($directory)
    {
        $directories = array();
        foreach (Finder::create()->in($directory)->directories()->depth(0) as $dir) {
            $directories[] = $dir->getPathname();
        }
        return $directories;
    }
    public function makeDirectory($path, $mode = 493, $recursive = false, $force = false)
    {
        if ($force) {
            return @mkdir($path, $mode, $recursive);
        }
        return mkdir($path, $mode, $recursive);
    }
    public function copyDirectory($directory, $destination, $options = null)
    {
        if (!$this->isDirectory($directory)) {
            return false;
        }
        $options = $options ?: FilesystemIterator::SKIP_DOTS;
        if (!$this->isDirectory($destination)) {
            $this->makeDirectory($destination, 511, true);
        }
        $items = new FilesystemIterator($directory, $options);
        foreach ($items as $item) {
            $target = $destination . '/' . $item->getBasename();
            if ($item->isDir()) {
                $path = $item->getPathname();
                if (!$this->copyDirectory($path, $target, $options)) {
                    return false;
                }
            } else {
                if (!$this->copy($item->getPathname(), $target)) {
                    return false;
                }
            }
        }
        return true;
    }
    public function deleteDirectory($directory, $preserve = false)
    {
        if (!$this->isDirectory($directory)) {
            return false;
        }
        $items = new FilesystemIterator($directory);
        foreach ($items as $item) {
            if ($item->isDir()) {
                $this->deleteDirectory($item->getPathname());
            } else {
                $this->delete($item->getPathname());
            }
        }
        if (!$preserve) {
            @rmdir($directory);
        }
        return true;
    }
    public function cleanDirectory($directory)
    {
        return $this->deleteDirectory($directory, true);
    }
}
namespace Illuminate\Foundation;

class AliasLoader
{
    protected $aliases;
    protected $registered = false;
    protected static $instance;
    private function __construct($aliases)
    {
        $this->aliases = $aliases;
    }
    public static function getInstance(array $aliases = array())
    {
        if (is_null(static::$instance)) {
            return static::$instance = new static($aliases);
        }
        $aliases = array_merge(static::$instance->getAliases(), $aliases);
        static::$instance->setAliases($aliases);
        return static::$instance;
    }
    public function load($alias)
    {
        if (isset($this->aliases[$alias])) {
            return class_alias($this->aliases[$alias], $alias);
        }
    }
    public function alias($class, $alias)
    {
        $this->aliases[$class] = $alias;
    }
    public function register()
    {
        if (!$this->registered) {
            $this->prependToLoaderStack();
            $this->registered = true;
        }
    }
    protected function prependToLoaderStack()
    {
        spl_autoload_register(array($this, 'load'), true, true);
    }
    public function getAliases()
    {
        return $this->aliases;
    }
    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }
    public function isRegistered()
    {
        return $this->registered;
    }
    public function setRegistered($value)
    {
        $this->registered = $value;
    }
    public static function setInstance($loader)
    {
        static::$instance = $loader;
    }
    private function __clone()
    {
        
    }
}
namespace Illuminate\Foundation;

use Illuminate\Filesystem\Filesystem;
class ProviderRepository
{
    protected $files;
    protected $manifestPath;
    protected $default = array('when' => array());
    public function __construct(Filesystem $files, $manifestPath)
    {
        $this->files = $files;
        $this->manifestPath = $manifestPath;
    }
    public function load(Application $app, array $providers)
    {
        $manifest = $this->loadManifest();
        if ($this->shouldRecompile($manifest, $providers)) {
            $manifest = $this->compileManifest($app, $providers);
        }
        if ($app->runningInConsole()) {
            $manifest['eager'] = $manifest['providers'];
        }
        foreach ($manifest['when'] as $provider => $events) {
            $this->registerLoadEvents($app, $provider, $events);
        }
        foreach ($manifest['eager'] as $provider) {
            $app->register($this->createProvider($app, $provider));
        }
        $app->setDeferredServices($manifest['deferred']);
    }
    protected function registerLoadEvents(Application $app, $provider, array $events)
    {
        if (count($events) < 1) {
            return;
        }
        $app->make('events')->listen($events, function () use($app, $provider) {
            $app->register($provider);
        });
    }
    protected function compileManifest(Application $app, $providers)
    {
        $manifest = $this->freshManifest($providers);
        foreach ($providers as $provider) {
            $instance = $this->createProvider($app, $provider);
            if ($instance->isDeferred()) {
                foreach ($instance->provides() as $service) {
                    $manifest['deferred'][$service] = $provider;
                }
                $manifest['when'][$provider] = $instance->when();
            } else {
                $manifest['eager'][] = $provider;
            }
        }
        return $this->writeManifest($manifest);
    }
    public function createProvider(Application $app, $provider)
    {
        return new $provider($app);
    }
    public function shouldRecompile($manifest, $providers)
    {
        return is_null($manifest) || $manifest['providers'] != $providers;
    }
    public function loadManifest()
    {
        $path = $this->manifestPath . '/services.json';
        if ($this->files->exists($path)) {
            $manifest = json_decode($this->files->get($path), true);
            return array_merge($this->default, $manifest);
        }
    }
    public function writeManifest($manifest)
    {
        $path = $this->manifestPath . '/services.json';
        $this->files->put($path, json_encode($manifest, JSON_PRETTY_PRINT));
        return $manifest;
    }
    protected function freshManifest(array $providers)
    {
        list($eager, $deferred) = array(array(), array());
        return compact('providers', 'eager', 'deferred');
    }
    public function getFilesystem()
    {
        return $this->files;
    }
}
namespace Illuminate\Cookie;

use Illuminate\Support\ServiceProvider;
class CookieServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bindShared('cookie', function ($app) {
            $config = $app['config']['session'];
            return (new CookieJar())->setDefaultPathAndDomain($config['path'], $config['domain']);
        });
    }
}
namespace Illuminate\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connectors\ConnectionFactory;
class DatabaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Model::setConnectionResolver($this->app['db']);
        Model::setEventDispatcher($this->app['events']);
    }
    public function register()
    {
        $this->registerQueueableEntityResolver();
        $this->app->bindShared('db.factory', function ($app) {
            return new ConnectionFactory($app);
        });
        $this->app->bindShared('db', function ($app) {
            return new DatabaseManager($app, $app['db.factory']);
        });
    }
    protected function registerQueueableEntityResolver()
    {
        $this->app->bindShared('Illuminate\\Contracts\\Queue\\EntityResolver', function () {
            return new Eloquent\QueueEntityResolver();
        });
    }
}
namespace Illuminate\Encryption;

use Illuminate\Support\ServiceProvider;
class EncryptionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bindShared('encrypter', function ($app) {
            $encrypter = new Encrypter($app['config']['app.key']);
            if ($app['config']->has('app.cipher')) {
                $encrypter->setCipher($app['config']['app.cipher']);
            }
            return $encrypter;
        });
    }
}
namespace Illuminate\Filesystem;

use Illuminate\Support\ServiceProvider;
class FilesystemServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerNativeFilesystem();
        $this->registerFlysystem();
    }
    protected function registerNativeFilesystem()
    {
        $this->app->bindShared('files', function () {
            return new Filesystem();
        });
    }
    protected function registerFlysystem()
    {
        $this->registerManager();
        $this->app->bindShared('filesystem.disk', function () {
            return $this->app['filesystem']->disk($this->getDefaultDriver());
        });
        $this->app->bindShared('filesystem.cloud', function () {
            return $this->app['filesystem']->disk($this->getCloudDriver());
        });
    }
    protected function registerManager()
    {
        $this->app->bindShared('filesystem', function () {
            return new FilesystemManager($this->app);
        });
    }
    protected function getDefaultDriver()
    {
        return $this->app['config']['filesystems.default'];
    }
    protected function getCloudDriver()
    {
        return $this->app['config']['filesystems.cloud'];
    }
}
namespace Illuminate\Session;

use Illuminate\Support\ServiceProvider;
class SessionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultDriver();
        $this->registerSessionManager();
        $this->registerSessionDriver();
    }
    protected function setupDefaultDriver()
    {
        if ($this->app->runningInConsole()) {
            $this->app['config']['session.driver'] = 'array';
        }
    }
    protected function registerSessionManager()
    {
        $this->app->bindShared('session', function ($app) {
            return new SessionManager($app);
        });
    }
    protected function registerSessionDriver()
    {
        $this->app->bindShared('session.store', function ($app) {
            $manager = $app['session'];
            return $manager->driver();
        });
    }
}
namespace Illuminate\View;

use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Compilers\BladeCompiler;
class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerEngineResolver();
        $this->registerViewFinder();
        $this->registerFactory();
    }
    public function registerEngineResolver()
    {
        $this->app->bindShared('view.engine.resolver', function () {
            $resolver = new EngineResolver();
            foreach (array('php', 'blade') as $engine) {
                $this->{'register' . ucfirst($engine) . 'Engine'}($resolver);
            }
            return $resolver;
        });
    }
    public function registerPhpEngine($resolver)
    {
        $resolver->register('php', function () {
            return new PhpEngine();
        });
    }
    public function registerBladeEngine($resolver)
    {
        $app = $this->app;
        $app->bindShared('blade.compiler', function ($app) {
            $cache = $app['config']['view.compiled'];
            return new BladeCompiler($app['files'], $cache);
        });
        $resolver->register('blade', function () use($app) {
            return new CompilerEngine($app['blade.compiler'], $app['files']);
        });
    }
    public function registerViewFinder()
    {
        $this->app->bindShared('view.finder', function ($app) {
            $paths = $app['config']['view.paths'];
            return new FileViewFinder($app['files'], $paths);
        });
    }
    public function registerFactory()
    {
        $this->app->bindShared('view', function ($app) {
            $resolver = $app['view.engine.resolver'];
            $finder = $app['view.finder'];
            $env = new Factory($resolver, $finder, $app['events']);
            $env->setContainer($app);
            $env->share('app', $app);
            return $env;
        });
    }
}
namespace Illuminate\Routing;

use ReflectionMethod;
use ReflectionFunctionAbstract;
trait RouteDependencyResolverTrait
{
    protected function callWithDependencies($instance, $method)
    {
        return call_user_func_array(array($instance, $method), $this->resolveClassMethodDependencies(array(), $instance, $method));
    }
    protected function resolveClassMethodDependencies(array $parameters, $instance, $method)
    {
        if (!method_exists($instance, $method)) {
            return $parameters;
        }
        return $this->resolveMethodDependencies($parameters, new ReflectionMethod($instance, $method));
    }
    public function resolveMethodDependencies(array $parameters, ReflectionFunctionAbstract $reflector)
    {
        foreach ($reflector->getParameters() as $key => $parameter) {
            $class = $parameter->getClass();
            if ($class && !$this->alreadyInParameters($class->name, $parameters)) {
                array_splice($parameters, $key, 0, array($this->container->make($class->name)));
            }
        }
        return $parameters;
    }
    protected function alreadyInParameters($class, array $parameters)
    {
        return !is_null(array_first($parameters, function ($key, $value) use($class) {
            return is_object($value) && get_class($value) === $class;
        }));
    }
}
namespace Illuminate\Routing;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Routing\RoutableInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Illuminate\Contracts\Routing\Registrar as RegistrarContract;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class Router implements HttpKernelInterface, RegistrarContract
{
    protected $events;
    protected $container;
    protected $routes;
    protected $current;
    protected $currentRequest;
    protected $middleware = array();
    protected $patternFilters = array();
    protected $regexFilters = array();
    protected $binders = array();
    protected $patterns = array();
    protected $groupStack = array();
    public static $verbs = array('GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS');
    public function __construct(Dispatcher $events, Container $container = null)
    {
        $this->events = $events;
        $this->routes = new RouteCollection();
        $this->container = $container ?: new Container();
    }
    public function get($uri, $action)
    {
        return $this->addRoute(array('GET', 'HEAD'), $uri, $action);
    }
    public function post($uri, $action)
    {
        return $this->addRoute('POST', $uri, $action);
    }
    public function put($uri, $action)
    {
        return $this->addRoute('PUT', $uri, $action);
    }
    public function patch($uri, $action)
    {
        return $this->addRoute('PATCH', $uri, $action);
    }
    public function delete($uri, $action)
    {
        return $this->addRoute('DELETE', $uri, $action);
    }
    public function options($uri, $action)
    {
        return $this->addRoute('OPTIONS', $uri, $action);
    }
    public function any($uri, $action)
    {
        $verbs = array('GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE');
        return $this->addRoute($verbs, $uri, $action);
    }
    public function match($methods, $uri, $action)
    {
        return $this->addRoute(array_map('strtoupper', (array) $methods), $uri, $action);
    }
    public function resource($name, $controller, array $options = array())
    {
        (new ResourceRegistrar($this))->register($name, $controller, $options);
    }
    public function group(array $attributes, Closure $callback)
    {
        $this->updateGroupStack($attributes);
        call_user_func($callback, $this);
        array_pop($this->groupStack);
    }
    protected function updateGroupStack(array $attributes)
    {
        if (!empty($this->groupStack)) {
            $attributes = $this->mergeGroup($attributes, last($this->groupStack));
        }
        $this->groupStack[] = $attributes;
    }
    public function mergeWithLastGroup($new)
    {
        return $this->mergeGroup($new, last($this->groupStack));
    }
    public static function mergeGroup($new, $old)
    {
        $new['namespace'] = static::formatUsesPrefix($new, $old);
        $new['prefix'] = static::formatGroupPrefix($new, $old);
        if (isset($new['domain'])) {
            unset($old['domain']);
        }
        $new['where'] = array_merge(array_get($old, 'where', array()), array_get($new, 'where', array()));
        return array_merge_recursive(array_except($old, array('namespace', 'prefix', 'where')), $new);
    }
    protected static function formatUsesPrefix($new, $old)
    {
        if (isset($new['namespace']) && isset($old['namespace'])) {
            return trim(array_get($old, 'namespace'), '\\') . '\\' . trim($new['namespace'], '\\');
        } elseif (isset($new['namespace'])) {
            return trim($new['namespace'], '\\');
        }
        return array_get($old, 'namespace');
    }
    protected static function formatGroupPrefix($new, $old)
    {
        if (isset($new['prefix'])) {
            return trim(array_get($old, 'prefix'), '/') . '/' . trim($new['prefix'], '/');
        }
        return array_get($old, 'prefix');
    }
    public function getLastGroupPrefix()
    {
        if (!empty($this->groupStack)) {
            $last = end($this->groupStack);
            return isset($last['prefix']) ? $last['prefix'] : '';
        }
        return '';
    }
    protected function addRoute($methods, $uri, $action)
    {
        return $this->routes->add($this->createRoute($methods, $uri, $action));
    }
    protected function createRoute($methods, $uri, $action)
    {
        if ($this->actionReferencesController($action)) {
            $action = $this->convertToControllerAction($action);
        }
        $route = $this->newRoute($methods, $uri = $this->prefix($uri), $action);
        if ($this->hasGroupStack()) {
            $this->mergeGroupAttributesIntoRoute($route);
        }
        $this->addWhereClausesToRoute($route);
        return $route;
    }
    protected function newRoute($methods, $uri, $action)
    {
        return (new Route($methods, $uri, $action))->setContainer($this->container);
    }
    protected function prefix($uri)
    {
        return trim(trim($this->getLastGroupPrefix(), '/') . '/' . trim($uri, '/'), '/') ?: '/';
    }
    protected function addWhereClausesToRoute($route)
    {
        $route->where(array_merge($this->patterns, array_get($route->getAction(), 'where', array())));
        return $route;
    }
    protected function mergeGroupAttributesIntoRoute($route)
    {
        $action = $this->mergeWithLastGroup($route->getAction());
        $route->setAction($action);
    }
    protected function actionReferencesController($action)
    {
        if ($action instanceof Closure) {
            return false;
        }
        return is_string($action) || is_string(array_get($action, 'uses'));
    }
    protected function convertToControllerAction($action)
    {
        if (is_string($action)) {
            $action = array('uses' => $action);
        }
        if (!empty($this->groupStack)) {
            $action['uses'] = $this->prependGroupUses($action['uses']);
        }
        $action['controller'] = $action['uses'];
        return $action;
    }
    protected function prependGroupUses($uses)
    {
        $group = last($this->groupStack);
        return isset($group['namespace']) ? $group['namespace'] . '\\' . $uses : $uses;
    }
    public function dispatch(Request $request)
    {
        $this->currentRequest = $request;
        $response = $this->callFilter('before', $request);
        if (is_null($response)) {
            $response = $this->dispatchToRoute($request);
        }
        $response = $this->prepareResponse($request, $response);
        $this->callFilter('after', $request, $response);
        return $response;
    }
    public function dispatchWithoutMiddleware(Request $request)
    {
        return $this->dispatch($request, false);
    }
    public function dispatchToRoute(Request $request)
    {
        $route = $this->findRoute($request);
        $request->setRouteResolver(function () use($route) {
            return $route;
        });
        $this->events->fire('router.matched', array($route, $request));
        $response = $this->callRouteBefore($route, $request);
        if (is_null($response)) {
            $response = $this->runRouteWithinStack($route, $request);
        }
        $response = $this->prepareResponse($request, $response);
        $this->callRouteAfter($route, $request, $response);
        return $response;
    }
    protected function runRouteWithinStack(Route $route, Request $request)
    {
        $middleware = $this->gatherRouteMiddlewares($route);
        return (new Stack\Stack(function ($request) use($route) {
            return $route->run($request);
        }, $middleware))->setContainer($this->container)->run($request);
    }
    protected function gatherRouteMiddlewares(Route $route)
    {
        return Collection::make($route->middleware())->map(function ($m) {
            return array_get($this->middleware, $m, $m);
        })->all();
    }
    protected function findRoute($request)
    {
        $this->current = $route = $this->routes->match($request);
        $this->container->instance('Illuminate\\Routing\\Route', $route);
        return $this->substituteBindings($route);
    }
    protected function substituteBindings($route)
    {
        foreach ($route->parameters() as $key => $value) {
            if (isset($this->binders[$key])) {
                $route->setParameter($key, $this->performBinding($key, $value, $route));
            }
        }
        return $route;
    }
    protected function performBinding($key, $value, $route)
    {
        return call_user_func($this->binders[$key], $value, $route);
    }
    public function matched($callback)
    {
        $this->events->listen('router.matched', $callback);
    }
    public function before($callback)
    {
        $this->addGlobalFilter('before', $callback);
    }
    public function after($callback)
    {
        $this->addGlobalFilter('after', $callback);
    }
    protected function addGlobalFilter($filter, $callback)
    {
        $this->events->listen('router.' . $filter, $this->parseFilter($callback));
    }
    public function getMiddleware()
    {
        return $this->middleware;
    }
    public function middleware($name, $class)
    {
        $this->middleware[$name] = $class;
        return $this;
    }
    public function filter($name, $callback)
    {
        $this->events->listen('router.filter: ' . $name, $this->parseFilter($callback));
    }
    protected function parseFilter($callback)
    {
        if (is_string($callback) && !str_contains($callback, '@')) {
            return $callback . '@filter';
        }
        return $callback;
    }
    public function when($pattern, $name, $methods = null)
    {
        if (!is_null($methods)) {
            $methods = array_map('strtoupper', (array) $methods);
        }
        $this->patternFilters[$pattern][] = compact('name', 'methods');
    }
    public function whenRegex($pattern, $name, $methods = null)
    {
        if (!is_null($methods)) {
            $methods = array_map('strtoupper', (array) $methods);
        }
        $this->regexFilters[$pattern][] = compact('name', 'methods');
    }
    public function model($key, $class, Closure $callback = null)
    {
        $this->bind($key, function ($value) use($class, $callback) {
            if (is_null($value)) {
                return null;
            }
            if ($model = (new $class())->find($value)) {
                return $model;
            }
            if ($callback instanceof Closure) {
                return call_user_func($callback);
            }
            throw new NotFoundHttpException();
        });
    }
    public function bind($key, $binder)
    {
        if (is_string($binder)) {
            $binder = $this->createClassBinding($binder);
        }
        $this->binders[str_replace('-', '_', $key)] = $binder;
    }
    public function createClassBinding($binding)
    {
        return function ($value, $route) use($binding) {
            $segments = explode('@', $binding);
            $method = count($segments) == 2 ? $segments[1] : 'bind';
            $callable = array($this->container->make($segments[0]), $method);
            return call_user_func($callable, $value, $route);
        };
    }
    public function pattern($key, $pattern)
    {
        $this->patterns[$key] = $pattern;
    }
    public function patterns($patterns)
    {
        foreach ($patterns as $key => $pattern) {
            $this->pattern($key, $pattern);
        }
    }
    protected function callFilter($filter, $request, $response = null)
    {
        return $this->events->until('router.' . $filter, array($request, $response));
    }
    public function callRouteBefore($route, $request)
    {
        $response = $this->callPatternFilters($route, $request);
        return $response ?: $this->callAttachedBefores($route, $request);
    }
    protected function callPatternFilters($route, $request)
    {
        foreach ($this->findPatternFilters($request) as $filter => $parameters) {
            $response = $this->callRouteFilter($filter, $parameters, $route, $request);
            if (!is_null($response)) {
                return $response;
            }
        }
    }
    public function findPatternFilters($request)
    {
        $results = array();
        list($path, $method) = array($request->path(), $request->getMethod());
        foreach ($this->patternFilters as $pattern => $filters) {
            if (str_is($pattern, $path)) {
                $merge = $this->patternsByMethod($method, $filters);
                $results = array_merge($results, $merge);
            }
        }
        foreach ($this->regexFilters as $pattern => $filters) {
            if (preg_match($pattern, $path)) {
                $merge = $this->patternsByMethod($method, $filters);
                $results = array_merge($results, $merge);
            }
        }
        return $results;
    }
    protected function patternsByMethod($method, $filters)
    {
        $results = array();
        foreach ($filters as $filter) {
            if ($this->filterSupportsMethod($filter, $method)) {
                $parsed = Route::parseFilters($filter['name']);
                $results = array_merge($results, $parsed);
            }
        }
        return $results;
    }
    protected function filterSupportsMethod($filter, $method)
    {
        $methods = $filter['methods'];
        return is_null($methods) || in_array($method, $methods);
    }
    protected function callAttachedBefores($route, $request)
    {
        foreach ($route->beforeFilters() as $filter => $parameters) {
            $response = $this->callRouteFilter($filter, $parameters, $route, $request);
            if (!is_null($response)) {
                return $response;
            }
        }
    }
    public function callRouteAfter($route, $request, $response)
    {
        foreach ($route->afterFilters() as $filter => $parameters) {
            $this->callRouteFilter($filter, $parameters, $route, $request, $response);
        }
    }
    public function callRouteFilter($filter, $parameters, $route, $request, $response = null)
    {
        $data = array_merge(array($route, $request, $response), $parameters);
        return $this->events->until('router.filter: ' . $filter, $this->cleanFilterParameters($data));
    }
    protected function cleanFilterParameters(array $parameters)
    {
        return array_filter($parameters, function ($p) {
            return !is_null($p) && $p !== '';
        });
    }
    protected function prepareResponse($request, $response)
    {
        if (!$response instanceof SymfonyResponse) {
            $response = new Response($response);
        }
        return $response->prepare($request);
    }
    public function hasGroupStack()
    {
        return !empty($this->groupStack);
    }
    public function getGroupStack()
    {
        return $this->groupStack;
    }
    public function input($key, $default = null)
    {
        return $this->current()->parameter($key, $default);
    }
    public function getCurrentRoute()
    {
        return $this->current();
    }
    public function current()
    {
        return $this->current;
    }
    public function has($name)
    {
        return $this->routes->hasNamedRoute($name);
    }
    public function currentRouteName()
    {
        return $this->current() ? $this->current()->getName() : null;
    }
    public function is()
    {
        foreach (func_get_args() as $pattern) {
            if (str_is($pattern, $this->currentRouteName())) {
                return true;
            }
        }
        return false;
    }
    public function currentRouteNamed($name)
    {
        return $this->current() ? $this->current()->getName() == $name : false;
    }
    public function currentRouteAction()
    {
        if (!$this->current()) {
            return;
        }
        $action = $this->current()->getAction();
        return isset($action['controller']) ? $action['controller'] : null;
    }
    public function uses()
    {
        foreach (func_get_args() as $pattern) {
            if (str_is($pattern, $this->currentRouteAction())) {
                return true;
            }
        }
        return false;
    }
    public function currentRouteUses($action)
    {
        return $this->currentRouteAction() == $action;
    }
    public function getCurrentRequest()
    {
        return $this->currentRequest;
    }
    public function getRoutes()
    {
        return $this->routes;
    }
    public function setRoutes(RouteCollection $routes)
    {
        foreach ($routes as $route) {
            $route->setContainer($this->container);
        }
        $this->routes = $routes;
        $this->container->instance('routes', $this->routes);
    }
    public function getPatterns()
    {
        return $this->patterns;
    }
    public function handle(SymfonyRequest $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        return $this->dispatch(Request::createFromBase($request));
    }
}
namespace Illuminate\Routing;

use Closure;
use ReflectionFunction;
use Illuminate\Http\Request;
use Illuminate\Container\Container;
use Illuminate\Routing\Matching\UriValidator;
use Illuminate\Routing\Matching\HostValidator;
use Illuminate\Routing\Matching\MethodValidator;
use Illuminate\Routing\Matching\SchemeValidator;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\Routing\Route as SymfonyRoute;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Routing\RouteDependencyResolverTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class Route
{
    use RouteDependencyResolverTrait;
    protected $uri;
    protected $methods;
    protected $action;
    protected $defaults = array();
    protected $wheres = array();
    protected $parameters;
    protected $parameterNames;
    protected $compiled;
    protected $container;
    protected static $validators;
    public function __construct($methods, $uri, $action)
    {
        $this->uri = $uri;
        $this->methods = (array) $methods;
        $this->action = $this->parseAction($action);
        if (in_array('GET', $this->methods) && !in_array('HEAD', $this->methods)) {
            $this->methods[] = 'HEAD';
        }
        if (isset($this->action['prefix'])) {
            $this->prefix($this->action['prefix']);
        }
    }
    public function run(Request $request)
    {
        $this->container = $this->container ?: new Container();
        try {
            if (!is_string($this->action['uses'])) {
                return $this->runCallable($request);
            }
            if ($this->customDispatcherIsBound()) {
                return $this->runWithCustomDispatcher($request);
            }
            return $this->runController($request);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        }
    }
    protected function runCallable(Request $request)
    {
        $parameters = $this->resolveMethodDependencies($this->parametersWithoutNulls(), new ReflectionFunction($this->action['uses']));
        return call_user_func_array($this->action['uses'], $parameters);
    }
    protected function runController(Request $request)
    {
        list($class, $method) = explode('@', $this->action['uses']);
        $parameters = $this->resolveClassMethodDependencies($this->parametersWithoutNulls(), $class, $method);
        if (!method_exists($instance = $this->container->make($class), $method)) {
            throw new NotFoundHttpException();
        }
        return call_user_func_array(array($instance, $method), $parameters);
    }
    protected function customDispatcherIsBound()
    {
        return $this->container->bound('illuminate.route.dispatcher');
    }
    protected function runWithCustomDispatcher(Request $request)
    {
        list($class, $method) = explode('@', $this->action['uses']);
        $dispatcher = $this->container->make('illuminate.route.dispatcher');
        return $dispatcher->dispatch($this, $request, $class, $method);
    }
    public function matches(Request $request, $includingMethod = true)
    {
        $this->compileRoute();
        foreach ($this->getValidators() as $validator) {
            if (!$includingMethod && $validator instanceof MethodValidator) {
                continue;
            }
            if (!$validator->matches($this, $request)) {
                return false;
            }
        }
        return true;
    }
    protected function compileRoute()
    {
        $optionals = $this->extractOptionalParameters();
        $uri = preg_replace('/\\{(\\w+?)\\?\\}/', '{$1}', $this->uri);
        $this->compiled = with(new SymfonyRoute($uri, $optionals, $this->wheres, array(), $this->domain() ?: ''))->compile();
    }
    protected function extractOptionalParameters()
    {
        preg_match_all('/\\{(\\w+?)\\?\\}/', $this->uri, $matches);
        return isset($matches[1]) ? array_fill_keys($matches[1], null) : array();
    }
    public function middleware()
    {
        return (array) array_get($this->action, 'middleware', array());
    }
    public function beforeFilters()
    {
        if (!isset($this->action['before'])) {
            return array();
        }
        return $this->parseFilters($this->action['before']);
    }
    public function afterFilters()
    {
        if (!isset($this->action['after'])) {
            return array();
        }
        return $this->parseFilters($this->action['after']);
    }
    public static function parseFilters($filters)
    {
        return array_build(static::explodeFilters($filters), function ($key, $value) {
            return Route::parseFilter($value);
        });
    }
    protected static function explodeFilters($filters)
    {
        if (is_array($filters)) {
            return static::explodeArrayFilters($filters);
        }
        return array_map('trim', explode('|', $filters));
    }
    protected static function explodeArrayFilters(array $filters)
    {
        $results = array();
        foreach ($filters as $filter) {
            $results = array_merge($results, array_map('trim', explode('|', $filter)));
        }
        return $results;
    }
    public static function parseFilter($filter)
    {
        if (!str_contains($filter, ':')) {
            return array($filter, array());
        }
        return static::parseParameterFilter($filter);
    }
    protected static function parseParameterFilter($filter)
    {
        list($name, $parameters) = explode(':', $filter, 2);
        return array($name, explode(',', $parameters));
    }
    public function hasParameter($name)
    {
        return array_key_exists($name, $this->parameters());
    }
    public function getParameter($name, $default = null)
    {
        return $this->parameter($name, $default);
    }
    public function parameter($name, $default = null)
    {
        return array_get($this->parameters(), $name, $default);
    }
    public function setParameter($name, $value)
    {
        $this->parameters();
        $this->parameters[$name] = $value;
    }
    public function forgetParameter($name)
    {
        $this->parameters();
        unset($this->parameters[$name]);
    }
    public function parameters()
    {
        if (isset($this->parameters)) {
            return array_map(function ($value) {
                return is_string($value) ? rawurldecode($value) : $value;
            }, $this->parameters);
        }
        throw new \LogicException('Route is not bound.');
    }
    public function parametersWithoutNulls()
    {
        return array_filter($this->parameters(), function ($p) {
            return !is_null($p);
        });
    }
    public function parameterNames()
    {
        if (isset($this->parameterNames)) {
            return $this->parameterNames;
        }
        return $this->parameterNames = $this->compileParameterNames();
    }
    protected function compileParameterNames()
    {
        preg_match_all('/\\{(.*?)\\}/', $this->domain() . $this->uri, $matches);
        return array_map(function ($m) {
            return trim($m, '?');
        }, $matches[1]);
    }
    public function bind(Request $request)
    {
        $this->compileRoute();
        $this->bindParameters($request);
        return $this;
    }
    public function bindParameters(Request $request)
    {
        $params = $this->matchToKeys(array_slice($this->bindPathParameters($request), 1));
        if (!is_null($this->compiled->getHostRegex())) {
            $params = $this->bindHostParameters($request, $params);
        }
        return $this->parameters = $this->replaceDefaults($params);
    }
    protected function bindPathParameters(Request $request)
    {
        preg_match($this->compiled->getRegex(), '/' . $request->decodedPath(), $matches);
        return $matches;
    }
    protected function bindHostParameters(Request $request, $parameters)
    {
        preg_match($this->compiled->getHostRegex(), $request->getHost(), $matches);
        return array_merge($this->matchToKeys(array_slice($matches, 1)), $parameters);
    }
    protected function matchToKeys(array $matches)
    {
        if (count($this->parameterNames()) == 0) {
            return array();
        }
        $parameters = array_intersect_key($matches, array_flip($this->parameterNames()));
        return array_filter($parameters, function ($value) {
            return is_string($value) && strlen($value) > 0;
        });
    }
    protected function replaceDefaults(array $parameters)
    {
        foreach ($parameters as $key => &$value) {
            $value = isset($value) ? $value : array_get($this->defaults, $key);
        }
        return $parameters;
    }
    protected function parseAction($action)
    {
        if (is_callable($action)) {
            return array('uses' => $action);
        } elseif (!isset($action['uses'])) {
            $action['uses'] = $this->findClosure($action);
        }
        return $action;
    }
    protected function findClosure(array $action)
    {
        return array_first($action, function ($key, $value) {
            return is_callable($value);
        });
    }
    public static function getValidators()
    {
        if (isset(static::$validators)) {
            return static::$validators;
        }
        return static::$validators = array(new MethodValidator(), new SchemeValidator(), new HostValidator(), new UriValidator());
    }
    public function before($filters)
    {
        return $this->addFilters('before', $filters);
    }
    public function after($filters)
    {
        return $this->addFilters('after', $filters);
    }
    protected function addFilters($type, $filters)
    {
        if (isset($this->action[$type])) {
            $this->action[$type] .= '|' . $filters;
        } else {
            $this->action[$type] = $filters;
        }
        return $this;
    }
    public function defaults($key, $value)
    {
        $this->defaults[$key] = $value;
        return $this;
    }
    public function where($name, $expression = null)
    {
        foreach ($this->parseWhere($name, $expression) as $name => $expression) {
            $this->wheres[$name] = $expression;
        }
        return $this;
    }
    protected function parseWhere($name, $expression)
    {
        return is_array($name) ? $name : array($name => $expression);
    }
    protected function whereArray(array $wheres)
    {
        foreach ($wheres as $name => $expression) {
            $this->where($name, $expression);
        }
        return $this;
    }
    public function prefix($prefix)
    {
        $this->uri = trim($prefix, '/') . '/' . trim($this->uri, '/');
        return $this;
    }
    public function getPath()
    {
        return $this->uri();
    }
    public function uri()
    {
        return $this->uri;
    }
    public function getMethods()
    {
        return $this->methods();
    }
    public function methods()
    {
        return $this->methods;
    }
    public function httpOnly()
    {
        return in_array('http', $this->action, true);
    }
    public function httpsOnly()
    {
        return $this->secure();
    }
    public function secure()
    {
        return in_array('https', $this->action, true);
    }
    public function domain()
    {
        return isset($this->action['domain']) ? $this->action['domain'] : null;
    }
    public function getUri()
    {
        return $this->uri;
    }
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }
    public function getPrefix()
    {
        return isset($this->action['prefix']) ? $this->action['prefix'] : null;
    }
    public function getName()
    {
        return isset($this->action['as']) ? $this->action['as'] : null;
    }
    public function getActionName()
    {
        return isset($this->action['controller']) ? $this->action['controller'] : 'Closure';
    }
    public function getAction()
    {
        return $this->action;
    }
    public function setAction(array $action)
    {
        $this->action = $action;
        return $this;
    }
    public function getCompiled()
    {
        return $this->compiled;
    }
    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }
    public function prepareForSerialization()
    {
        if ($this->action['uses'] instanceof Closure) {
            throw new \LogicException("Unable to prepare route [{$this->uri}] for serialization. Uses Closure.");
        }
        unset($this->container);
        unset($this->compiled);
    }
}
namespace Illuminate\Routing;

use Countable;
use ArrayIterator;
use IteratorAggregate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
class RouteCollection implements Countable, IteratorAggregate
{
    protected $routes = array();
    protected $allRoutes = array();
    protected $nameList = array();
    protected $actionList = array();
    public function add(Route $route)
    {
        $this->addToCollections($route);
        $this->addLookups($route);
        return $route;
    }
    protected function addToCollections($route)
    {
        $domainAndUri = $route->domain() . $route->getUri();
        foreach ($route->methods() as $method) {
            $this->routes[$method][$domainAndUri] = $route;
        }
        $this->allRoutes[$method . $domainAndUri] = $route;
    }
    protected function addLookups($route)
    {
        $action = $route->getAction();
        if (isset($action['as'])) {
            $this->nameList[$action['as']] = $route;
        }
        if (isset($action['controller'])) {
            $this->addToActionList($action, $route);
        }
    }
    protected function addToActionList($action, $route)
    {
        $this->actionList[$action['controller']] = $route;
    }
    public function match(Request $request)
    {
        $routes = $this->get($request->getMethod());
        $route = $this->check($routes, $request);
        if (!is_null($route)) {
            return $route->bind($request);
        }
        $others = $this->checkForAlternateVerbs($request);
        if (count($others) > 0) {
            return $this->getRouteForMethods($request, $others);
        }
        throw new NotFoundHttpException();
    }
    protected function checkForAlternateVerbs($request)
    {
        $methods = array_diff(Router::$verbs, array($request->getMethod()));
        $others = array();
        foreach ($methods as $method) {
            if (!is_null($this->check($this->get($method), $request, false))) {
                $others[] = $method;
            }
        }
        return $others;
    }
    protected function getRouteForMethods($request, array $methods)
    {
        if ($request->method() == 'OPTIONS') {
            return (new Route('OPTIONS', $request->path(), function () use($methods) {
                return new Response('', 200, array('Allow' => implode(',', $methods)));
            }))->bind($request);
        }
        $this->methodNotAllowed($methods);
    }
    protected function methodNotAllowed(array $others)
    {
        throw new MethodNotAllowedHttpException($others);
    }
    protected function check(array $routes, $request, $includingMethod = true)
    {
        return array_first($routes, function ($key, $value) use($request, $includingMethod) {
            return $value->matches($request, $includingMethod);
        });
    }
    protected function get($method = null)
    {
        if (is_null($method)) {
            return $this->getRoutes();
        }
        return array_get($this->routes, $method, array());
    }
    public function hasNamedRoute($name)
    {
        return !is_null($this->getByName($name));
    }
    public function getByName($name)
    {
        return isset($this->nameList[$name]) ? $this->nameList[$name] : null;
    }
    public function getByAction($action)
    {
        return isset($this->actionList[$action]) ? $this->actionList[$action] : null;
    }
    public function getRoutes()
    {
        return array_values($this->allRoutes);
    }
    public function getIterator()
    {
        return new ArrayIterator($this->getRoutes());
    }
    public function count()
    {
        return count($this->getRoutes());
    }
}
namespace Symfony\Component\Routing;

class CompiledRoute
{
    private $variables;
    private $tokens;
    private $staticPrefix;
    private $regex;
    private $pathVariables;
    private $hostVariables;
    private $hostRegex;
    private $hostTokens;
    public function __construct($staticPrefix, $regex, array $tokens, array $pathVariables, $hostRegex = null, array $hostTokens = array(), array $hostVariables = array(), array $variables = array())
    {
        $this->staticPrefix = (string) $staticPrefix;
        $this->regex = $regex;
        $this->tokens = $tokens;
        $this->pathVariables = $pathVariables;
        $this->hostRegex = $hostRegex;
        $this->hostTokens = $hostTokens;
        $this->hostVariables = $hostVariables;
        $this->variables = $variables;
    }
    public function getStaticPrefix()
    {
        return $this->staticPrefix;
    }
    public function getRegex()
    {
        return $this->regex;
    }
    public function getHostRegex()
    {
        return $this->hostRegex;
    }
    public function getTokens()
    {
        return $this->tokens;
    }
    public function getHostTokens()
    {
        return $this->hostTokens;
    }
    public function getVariables()
    {
        return $this->variables;
    }
    public function getPathVariables()
    {
        return $this->pathVariables;
    }
    public function getHostVariables()
    {
        return $this->hostVariables;
    }
}
namespace Symfony\Component\Routing;

interface RouteCompilerInterface
{
    public static function compile(Route $route);
}
namespace Symfony\Component\Routing;

class RouteCompiler implements RouteCompilerInterface
{
    const REGEX_DELIMITER = '#';
    const SEPARATORS = '/,;.:-_~+*=@|';
    public static function compile(Route $route)
    {
        $staticPrefix = null;
        $hostVariables = array();
        $pathVariables = array();
        $variables = array();
        $tokens = array();
        $regex = null;
        $hostRegex = null;
        $hostTokens = array();
        if ('' !== ($host = $route->getHost())) {
            $result = self::compilePattern($route, $host, true);
            $hostVariables = $result['variables'];
            $variables = array_merge($variables, $hostVariables);
            $hostTokens = $result['tokens'];
            $hostRegex = $result['regex'];
        }
        $path = $route->getPath();
        $result = self::compilePattern($route, $path, false);
        $staticPrefix = $result['staticPrefix'];
        $pathVariables = $result['variables'];
        $variables = array_merge($variables, $pathVariables);
        $tokens = $result['tokens'];
        $regex = $result['regex'];
        return new CompiledRoute($staticPrefix, $regex, $tokens, $pathVariables, $hostRegex, $hostTokens, $hostVariables, array_unique($variables));
    }
    private static function compilePattern(Route $route, $pattern, $isHost)
    {
        $tokens = array();
        $variables = array();
        $matches = array();
        $pos = 0;
        $defaultSeparator = $isHost ? '.' : '/';
        preg_match_all('#\\{\\w+\\}#', $pattern, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
        foreach ($matches as $match) {
            $varName = substr($match[0][0], 1, -1);
            $precedingText = substr($pattern, $pos, $match[0][1] - $pos);
            $pos = $match[0][1] + strlen($match[0][0]);
            $precedingChar = strlen($precedingText) > 0 ? substr($precedingText, -1) : '';
            $isSeparator = '' !== $precedingChar && false !== strpos(static::SEPARATORS, $precedingChar);
            if (is_numeric($varName)) {
                throw new \DomainException(sprintf('Variable name "%s" cannot be numeric in route pattern "%s". Please use a different name.', $varName, $pattern));
            }
            if (in_array($varName, $variables)) {
                throw new \LogicException(sprintf('Route pattern "%s" cannot reference variable name "%s" more than once.', $pattern, $varName));
            }
            if ($isSeparator && strlen($precedingText) > 1) {
                $tokens[] = array('text', substr($precedingText, 0, -1));
            } elseif (!$isSeparator && strlen($precedingText) > 0) {
                $tokens[] = array('text', $precedingText);
            }
            $regexp = $route->getRequirement($varName);
            if (null === $regexp) {
                $followingPattern = (string) substr($pattern, $pos);
                $nextSeparator = self::findNextSeparator($followingPattern);
                $regexp = sprintf('[^%s%s]+', preg_quote($defaultSeparator, self::REGEX_DELIMITER), $defaultSeparator !== $nextSeparator && '' !== $nextSeparator ? preg_quote($nextSeparator, self::REGEX_DELIMITER) : '');
                if ('' !== $nextSeparator && !preg_match('#^\\{\\w+\\}#', $followingPattern) || '' === $followingPattern) {
                    $regexp .= '+';
                }
            }
            $tokens[] = array('variable', $isSeparator ? $precedingChar : '', $regexp, $varName);
            $variables[] = $varName;
        }
        if ($pos < strlen($pattern)) {
            $tokens[] = array('text', substr($pattern, $pos));
        }
        $firstOptional = PHP_INT_MAX;
        if (!$isHost) {
            for ($i = count($tokens) - 1; $i >= 0; $i--) {
                $token = $tokens[$i];
                if ('variable' === $token[0] && $route->hasDefault($token[3])) {
                    $firstOptional = $i;
                } else {
                    break;
                }
            }
        }
        $regexp = '';
        for ($i = 0, $nbToken = count($tokens); $i < $nbToken; $i++) {
            $regexp .= self::computeRegexp($tokens, $i, $firstOptional);
        }
        return array('staticPrefix' => 'text' === $tokens[0][0] ? $tokens[0][1] : '', 'regex' => self::REGEX_DELIMITER . '^' . $regexp . '$' . self::REGEX_DELIMITER . 's', 'tokens' => array_reverse($tokens), 'variables' => $variables);
    }
    private static function findNextSeparator($pattern)
    {
        if ('' == $pattern) {
            return '';
        }
        $pattern = preg_replace('#\\{\\w+\\}#', '', $pattern);
        return isset($pattern[0]) && false !== strpos(static::SEPARATORS, $pattern[0]) ? $pattern[0] : '';
    }
    private static function computeRegexp(array $tokens, $index, $firstOptional)
    {
        $token = $tokens[$index];
        if ('text' === $token[0]) {
            return preg_quote($token[1], self::REGEX_DELIMITER);
        } else {
            if (0 === $index && 0 === $firstOptional) {
                return sprintf('%s(?P<%s>%s)?', preg_quote($token[1], self::REGEX_DELIMITER), $token[3], $token[2]);
            } else {
                $regexp = sprintf('%s(?P<%s>%s)', preg_quote($token[1], self::REGEX_DELIMITER), $token[3], $token[2]);
                if ($index >= $firstOptional) {
                    $regexp = "(?:{$regexp}";
                    $nbTokens = count($tokens);
                    if ($nbTokens - 1 == $index) {
                        $regexp .= str_repeat(')?', $nbTokens - $firstOptional - (0 === $firstOptional ? 1 : 0));
                    }
                }
                return $regexp;
            }
        }
    }
}
namespace Symfony\Component\Routing;

class Route implements \Serializable
{
    private $path = '/';
    private $host = '';
    private $schemes = array();
    private $methods = array();
    private $defaults = array();
    private $requirements = array();
    private $options = array();
    private $compiled;
    private $condition;
    public function __construct($path, array $defaults = array(), array $requirements = array(), array $options = array(), $host = '', $schemes = array(), $methods = array(), $condition = null)
    {
        $this->setPath($path);
        $this->setDefaults($defaults);
        $this->setRequirements($requirements);
        $this->setOptions($options);
        $this->setHost($host);
        if ($schemes) {
            $this->setSchemes($schemes);
        }
        if ($methods) {
            $this->setMethods($methods);
        }
        $this->setCondition($condition);
    }
    public function serialize()
    {
        return serialize(array('path' => $this->path, 'host' => $this->host, 'defaults' => $this->defaults, 'requirements' => $this->requirements, 'options' => $this->options, 'schemes' => $this->schemes, 'methods' => $this->methods, 'condition' => $this->condition));
    }
    public function unserialize($data)
    {
        $data = unserialize($data);
        $this->path = $data['path'];
        $this->host = $data['host'];
        $this->defaults = $data['defaults'];
        $this->requirements = $data['requirements'];
        $this->options = $data['options'];
        $this->schemes = $data['schemes'];
        $this->methods = $data['methods'];
        $this->condition = $data['condition'];
    }
    public function getPattern()
    {
        return $this->path;
    }
    public function setPattern($pattern)
    {
        return $this->setPath($pattern);
    }
    public function getPath()
    {
        return $this->path;
    }
    public function setPath($pattern)
    {
        $this->path = '/' . ltrim(trim($pattern), '/');
        $this->compiled = null;
        return $this;
    }
    public function getHost()
    {
        return $this->host;
    }
    public function setHost($pattern)
    {
        $this->host = (string) $pattern;
        $this->compiled = null;
        return $this;
    }
    public function getSchemes()
    {
        return $this->schemes;
    }
    public function setSchemes($schemes)
    {
        $this->schemes = array_map('strtolower', (array) $schemes);
        if ($this->schemes) {
            $this->requirements['_scheme'] = implode('|', $this->schemes);
        } else {
            unset($this->requirements['_scheme']);
        }
        $this->compiled = null;
        return $this;
    }
    public function hasScheme($scheme)
    {
        $scheme = strtolower($scheme);
        foreach ($this->schemes as $requiredScheme) {
            if ($scheme === $requiredScheme) {
                return true;
            }
        }
        return false;
    }
    public function getMethods()
    {
        return $this->methods;
    }
    public function setMethods($methods)
    {
        $this->methods = array_map('strtoupper', (array) $methods);
        if ($this->methods) {
            $this->requirements['_method'] = implode('|', $this->methods);
        } else {
            unset($this->requirements['_method']);
        }
        $this->compiled = null;
        return $this;
    }
    public function getOptions()
    {
        return $this->options;
    }
    public function setOptions(array $options)
    {
        $this->options = array('compiler_class' => 'Symfony\\Component\\Routing\\RouteCompiler');
        return $this->addOptions($options);
    }
    public function addOptions(array $options)
    {
        foreach ($options as $name => $option) {
            $this->options[$name] = $option;
        }
        $this->compiled = null;
        return $this;
    }
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
        $this->compiled = null;
        return $this;
    }
    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }
    public function hasOption($name)
    {
        return array_key_exists($name, $this->options);
    }
    public function getDefaults()
    {
        return $this->defaults;
    }
    public function setDefaults(array $defaults)
    {
        $this->defaults = array();
        return $this->addDefaults($defaults);
    }
    public function addDefaults(array $defaults)
    {
        foreach ($defaults as $name => $default) {
            $this->defaults[$name] = $default;
        }
        $this->compiled = null;
        return $this;
    }
    public function getDefault($name)
    {
        return isset($this->defaults[$name]) ? $this->defaults[$name] : null;
    }
    public function hasDefault($name)
    {
        return array_key_exists($name, $this->defaults);
    }
    public function setDefault($name, $default)
    {
        $this->defaults[$name] = $default;
        $this->compiled = null;
        return $this;
    }
    public function getRequirements()
    {
        return $this->requirements;
    }
    public function setRequirements(array $requirements)
    {
        $this->requirements = array();
        return $this->addRequirements($requirements);
    }
    public function addRequirements(array $requirements)
    {
        foreach ($requirements as $key => $regex) {
            $this->requirements[$key] = $this->sanitizeRequirement($key, $regex);
        }
        $this->compiled = null;
        return $this;
    }
    public function getRequirement($key)
    {
        return isset($this->requirements[$key]) ? $this->requirements[$key] : null;
    }
    public function hasRequirement($key)
    {
        return array_key_exists($key, $this->requirements);
    }
    public function setRequirement($key, $regex)
    {
        $this->requirements[$key] = $this->sanitizeRequirement($key, $regex);
        $this->compiled = null;
        return $this;
    }
    public function getCondition()
    {
        return $this->condition;
    }
    public function setCondition($condition)
    {
        $this->condition = (string) $condition;
        $this->compiled = null;
        return $this;
    }
    public function compile()
    {
        if (null !== $this->compiled) {
            return $this->compiled;
        }
        $class = $this->getOption('compiler_class');
        return $this->compiled = $class::compile($this);
    }
    private function sanitizeRequirement($key, $regex)
    {
        if (!is_string($regex)) {
            throw new \InvalidArgumentException(sprintf('Routing requirement for "%s" must be a string.', $key));
        }
        if ('' !== $regex && '^' === $regex[0]) {
            $regex = (string) substr($regex, 1);
        }
        if ('$' === substr($regex, -1)) {
            $regex = substr($regex, 0, -1);
        }
        if ('' === $regex) {
            throw new \InvalidArgumentException(sprintf('Routing requirement for "%s" cannot be empty.', $key));
        }
        if ('_scheme' === $key) {
            $this->setSchemes(explode('|', $regex));
        } elseif ('_method' === $key) {
            $this->setMethods(explode('|', $regex));
        }
        return $regex;
    }
}
namespace Illuminate\Routing;

use Closure;
use Illuminate\Container\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
abstract class Controller
{
    protected $middleware = array();
    protected $beforeFilters = array();
    protected $afterFilters = array();
    protected static $router;
    public function middleware($middleware, array $options = array())
    {
        $this->middleware[$middleware] = $options;
    }
    public function beforeFilter($filter, array $options = array())
    {
        $this->beforeFilters[] = $this->parseFilter($filter, $options);
    }
    public function afterFilter($filter, array $options = array())
    {
        $this->afterFilters[] = $this->parseFilter($filter, $options);
    }
    protected function parseFilter($filter, array $options)
    {
        $parameters = array();
        $original = $filter;
        if ($filter instanceof Closure) {
            $filter = $this->registerClosureFilter($filter);
        } elseif ($this->isInstanceFilter($filter)) {
            $filter = $this->registerInstanceFilter($filter);
        } else {
            list($filter, $parameters) = Route::parseFilter($filter);
        }
        return compact('original', 'filter', 'parameters', 'options');
    }
    protected function registerClosureFilter(Closure $filter)
    {
        $this->getRouter()->filter($name = spl_object_hash($filter), $filter);
        return $name;
    }
    protected function registerInstanceFilter($filter)
    {
        $this->getRouter()->filter($filter, array($this, substr($filter, 1)));
        return $filter;
    }
    protected function isInstanceFilter($filter)
    {
        if (is_string($filter) && starts_with($filter, '@')) {
            if (method_exists($this, substr($filter, 1))) {
                return true;
            }
            throw new \InvalidArgumentException("Filter method [{$filter}] does not exist.");
        }
        return false;
    }
    public function forgetBeforeFilter($filter)
    {
        $this->beforeFilters = $this->removeFilter($filter, $this->getBeforeFilters());
    }
    public function forgetAfterFilter($filter)
    {
        $this->afterFilters = $this->removeFilter($filter, $this->getAfterFilters());
    }
    protected function removeFilter($removing, $current)
    {
        return array_filter($current, function ($filter) use($removing) {
            return $filter['original'] != $removing;
        });
    }
    public function getMiddleware()
    {
        return $this->middleware;
    }
    public function getBeforeFilters()
    {
        return $this->beforeFilters;
    }
    public function getAfterFilters()
    {
        return $this->afterFilters;
    }
    public static function getRouter()
    {
        return static::$router;
    }
    public static function setRouter(Router $router)
    {
        static::$router = $router;
    }
    public function callAction($method, $parameters)
    {
        return call_user_func_array(array($this, $method), $parameters);
    }
    public function __call($method, $parameters)
    {
        throw new \BadMethodCallException("Method [{$method}] does not exist.");
    }
}
namespace Illuminate\Routing;

use Closure;
use ReflectionMethod;
use Illuminate\Http\Request;
use Illuminate\Container\Container;
use Illuminate\Routing\Stack\Stack;
use Illuminate\Support\Collection;
use Illuminate\Routing\RouteDependencyResolverTrait;
class ControllerDispatcher
{
    use RouteDependencyResolverTrait;
    protected $router;
    protected $container;
    public function __construct(Router $router, Container $container = null)
    {
        $this->router = $router;
        $this->container = $container;
    }
    public function dispatch(Route $route, Request $request, $controller, $method)
    {
        $instance = $this->makeController($controller);
        $this->assignAfter($instance, $route, $request, $method);
        $response = $this->before($instance, $route, $request, $method);
        if (is_null($response)) {
            $response = $this->callWithinStack($instance, $route, $request, $method);
        }
        return $response;
    }
    protected function makeController($controller)
    {
        Controller::setRouter($this->router);
        return $this->container->make($controller);
    }
    protected function callWithinStack($instance, $route, $request, $method)
    {
        $middleware = $this->getMiddleware($instance, $method);
        return (new Stack(function ($request) use($instance, $route, $method) {
            return $this->call($instance, $route, $method);
        }, $middleware))->setContainer($this->container)->run($request);
    }
    protected function getMiddleware($instance, $method)
    {
        $middleware = $this->router->getMiddleware();
        $results = array();
        foreach ($instance->getMiddleware() as $name => $options) {
            if (!$this->methodExcludedByOptions($method, $options)) {
                $results[] = array_get($middleware, $name, $name);
            }
        }
        return $results;
    }
    public function methodExcludedByOptions($method, array $options)
    {
        return !empty($options['only']) && !in_array($method, (array) $options['only']) || !empty($options['except']) && in_array($method, (array) $options['except']);
    }
    protected function call($instance, $route, $method)
    {
        $parameters = $this->resolveClassMethodDependencies($route->parametersWithoutNulls(), $instance, $method);
        return $instance->callAction($method, $parameters);
    }
    protected function before($instance, $route, $request, $method)
    {
        foreach ($instance->getBeforeFilters() as $filter) {
            if ($this->filterApplies($filter, $request, $method)) {
                $response = $this->callFilter($filter, $route, $request);
                if (!is_null($response)) {
                    return $response;
                }
            }
        }
    }
    protected function assignAfter($instance, $route, $request, $method)
    {
        foreach ($instance->getAfterFilters() as $filter) {
            if ($this->filterApplies($filter, $request, $method)) {
                $route->after($this->getAssignableAfter($filter));
            }
        }
    }
    protected function getAssignableAfter($filter)
    {
        if ($filter['original'] instanceof Closure) {
            return $filter['filter'];
        }
        return $filter['original'];
    }
    protected function filterApplies($filter, $request, $method)
    {
        foreach (array('Method', 'On') as $type) {
            if ($this->{"filterFails{$type}"}($filter, $request, $method)) {
                return false;
            }
        }
        return true;
    }
    protected function filterFailsMethod($filter, $request, $method)
    {
        return $this->methodExcludedByOptions($method, $filter['options']);
    }
    protected function filterFailsOn($filter, $request, $method)
    {
        $on = array_get($filter, 'options.on');
        if (is_null($on)) {
            return false;
        }
        if (is_string($on)) {
            $on = explode('|', $on);
        }
        return !in_array(strtolower($request->getMethod()), $on);
    }
    protected function callFilter($filter, $route, $request)
    {
        return $this->router->callRouteFilter($filter['filter'], $filter['parameters'], $route, $request);
    }
}
namespace Illuminate\Routing;

use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorContract;
class UrlGenerator implements UrlGeneratorContract
{
    protected $routes;
    protected $request;
    protected $forcedRoot;
    protected $forceSchema;
    protected $rootNamespace;
    protected $dontEncode = array('%2F' => '/', '%40' => '@', '%3A' => ':', '%3B' => ';', '%2C' => ',', '%3D' => '=', '%2B' => '+', '%21' => '!', '%2A' => '*', '%7C' => '|');
    public function __construct(RouteCollection $routes, Request $request)
    {
        $this->routes = $routes;
        $this->setRequest($request);
    }
    public function full()
    {
        return $this->request->fullUrl();
    }
    public function current()
    {
        return $this->to($this->request->getPathInfo());
    }
    public function previous()
    {
        return $this->to($this->request->headers->get('referer'));
    }
    public function to($path, $extra = array(), $secure = null)
    {
        if ($this->isValidUrl($path)) {
            return $path;
        }
        $scheme = $this->getScheme($secure);
        $extra = $this->formatParameters($extra);
        $tail = implode('/', array_map('rawurlencode', (array) $extra));
        $root = $this->getRootUrl($scheme);
        return $this->trimUrl($root, $path, $tail);
    }
    public function secure($path, $parameters = array())
    {
        return $this->to($path, $parameters, true);
    }
    public function asset($path, $secure = null)
    {
        if ($this->isValidUrl($path)) {
            return $path;
        }
        $root = $this->getRootUrl($this->getScheme($secure));
        return $this->removeIndex($root) . '/' . trim($path, '/');
    }
    protected function removeIndex($root)
    {
        $i = 'index.php';
        return str_contains($root, $i) ? str_replace('/' . $i, '', $root) : $root;
    }
    public function secureAsset($path)
    {
        return $this->asset($path, true);
    }
    protected function getScheme($secure)
    {
        if (is_null($secure)) {
            return $this->forceSchema ?: $this->request->getScheme() . '://';
        }
        return $secure ? 'https://' : 'http://';
    }
    public function forceSchema($schema)
    {
        $this->forceSchema = $schema . '://';
    }
    public function route($name, $parameters = array(), $absolute = true)
    {
        if (!is_null($route = $this->routes->getByName($name))) {
            return $this->toRoute($route, $parameters, $absolute);
        }
        throw new InvalidArgumentException("Route [{$name}] not defined.");
    }
    protected function toRoute($route, array $parameters, $absolute)
    {
        $parameters = $this->formatParameters($parameters);
        $domain = $this->getRouteDomain($route, $parameters);
        $uri = strtr(rawurlencode($this->trimUrl($root = $this->replaceRoot($route, $domain, $parameters), $this->replaceRouteParameters($route->uri(), $parameters))), $this->dontEncode) . $this->getRouteQueryString($parameters);
        return $absolute ? $uri : '/' . ltrim(str_replace($root, '', $uri), '/');
    }
    protected function replaceRoot($route, $domain, &$parameters)
    {
        return $this->replaceRouteParameters($this->getRouteRoot($route, $domain), $parameters);
    }
    protected function replaceRouteParameters($path, array &$parameters)
    {
        if (count($parameters)) {
            $path = preg_replace_sub('/\\{.*?\\}/', $parameters, $this->replaceNamedParameters($path, $parameters));
        }
        return trim(preg_replace('/\\{.*?\\?\\}/', '', $path), '/');
    }
    protected function replaceNamedParameters($path, &$parameters)
    {
        return preg_replace_callback('/\\{(.*?)\\??\\}/', function ($m) use(&$parameters) {
            return isset($parameters[$m[1]]) ? array_pull($parameters, $m[1]) : $m[0];
        }, $path);
    }
    protected function formatParameters($parameters)
    {
        return $this->replaceRoutableParameters($parameters);
    }
    protected function replaceRoutableParameters($parameters = array())
    {
        $parameters = is_array($parameters) ? $parameters : array($parameters);
        foreach ($parameters as $key => $parameter) {
            if ($parameter instanceof UrlRoutable) {
                $parameters[$key] = $parameter->getRouteKey();
            }
        }
        return $parameters;
    }
    protected function getRouteQueryString(array $parameters)
    {
        if (count($parameters) == 0) {
            return '';
        }
        $query = http_build_query($keyed = $this->getStringParameters($parameters));
        if (count($keyed) < count($parameters)) {
            $query .= '&' . implode('&', $this->getNumericParameters($parameters));
        }
        return '?' . trim($query, '&');
    }
    protected function getStringParameters(array $parameters)
    {
        return array_where($parameters, function ($k, $v) {
            return is_string($k);
        });
    }
    protected function getNumericParameters(array $parameters)
    {
        return array_where($parameters, function ($k, $v) {
            return is_numeric($k);
        });
    }
    protected function getRouteDomain($route, &$parameters)
    {
        return $route->domain() ? $this->formatDomain($route, $parameters) : null;
    }
    protected function formatDomain($route, &$parameters)
    {
        return $this->addPortToDomain($this->getDomainAndScheme($route));
    }
    protected function getDomainAndScheme($route)
    {
        return $this->getRouteScheme($route) . $route->domain();
    }
    protected function addPortToDomain($domain)
    {
        if (in_array($this->request->getPort(), array('80', '443'))) {
            return $domain;
        }
        return $domain . ':' . $this->request->getPort();
    }
    protected function getRouteRoot($route, $domain)
    {
        return $this->getRootUrl($this->getRouteScheme($route), $domain);
    }
    protected function getRouteScheme($route)
    {
        if ($route->httpOnly()) {
            return $this->getScheme(false);
        } elseif ($route->httpsOnly()) {
            return $this->getScheme(true);
        }
        return $this->getScheme(null);
    }
    public function action($action, $parameters = array(), $absolute = true)
    {
        if ($this->rootNamespace && !(strpos($action, '\\') === 0)) {
            $action = $this->rootNamespace . '\\' . $action;
        } else {
            $action = trim($action, '\\');
        }
        return $this->toRoute($this->routes->getByAction($action), $parameters, $absolute);
    }
    protected function getRootUrl($scheme, $root = null)
    {
        if (is_null($root)) {
            $root = $this->forcedRoot ?: $this->request->root();
        }
        $start = starts_with($root, 'http://') ? 'http://' : 'https://';
        return preg_replace('~' . $start . '~', $scheme, $root, 1);
    }
    public function forceRootUrl($root)
    {
        $this->forcedRoot = $root;
    }
    public function isValidUrl($path)
    {
        if (starts_with($path, array('#', '//', 'mailto:', 'tel:'))) {
            return true;
        }
        return filter_var($path, FILTER_VALIDATE_URL) !== false;
    }
    protected function trimUrl($root, $path, $tail = '')
    {
        return trim($root . '/' . trim($path . '/' . $tail, '/'), '/');
    }
    public function getRequest()
    {
        return $this->request;
    }
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }
    public function setRoutes(RouteCollection $routes)
    {
        $this->routes = $routes;
        return $this;
    }
    public function setRootControllerNamespace($rootNamespace)
    {
        $this->rootNamespace = $rootNamespace;
        return $this;
    }
}
namespace Illuminate\Routing\Matching;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
interface ValidatorInterface
{
    public function matches(Route $route, Request $request);
}
namespace Illuminate\Routing\Matching;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
class HostValidator implements ValidatorInterface
{
    public function matches(Route $route, Request $request)
    {
        if (is_null($route->getCompiled()->getHostRegex())) {
            return true;
        }
        return preg_match($route->getCompiled()->getHostRegex(), $request->getHost());
    }
}
namespace Illuminate\Routing\Matching;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
class MethodValidator implements ValidatorInterface
{
    public function matches(Route $route, Request $request)
    {
        return in_array($request->getMethod(), $route->methods());
    }
}
namespace Illuminate\Routing\Matching;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
class SchemeValidator implements ValidatorInterface
{
    public function matches(Route $route, Request $request)
    {
        if ($route->httpOnly()) {
            return !$request->secure();
        } elseif ($route->secure()) {
            return $request->secure();
        }
        return true;
    }
}
namespace Illuminate\Routing\Matching;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
class UriValidator implements ValidatorInterface
{
    public function matches(Route $route, Request $request)
    {
        $path = $request->path() == '/' ? '/' : '/' . $request->path();
        return preg_match($route->getCompiled()->getRegex(), rawurldecode($path));
    }
}
namespace Illuminate\Workbench;

use Illuminate\Support\ServiceProvider;
use Illuminate\Workbench\Console\WorkbenchMakeCommand;
class WorkbenchServiceProvider extends ServiceProvider
{
    protected $defer = false;
    public function register()
    {
        $this->app->bindShared('package.creator', function ($app) {
            return new PackageCreator($app['files']);
        });
        $this->app->bindShared('command.workbench', function ($app) {
            return new WorkbenchMakeCommand($app['package.creator']);
        });
        $this->commands('command.workbench');
    }
    public function provides()
    {
        return array('package.creator', 'command.workbench');
    }
}
namespace Illuminate\Events;

use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
class Dispatcher implements DispatcherContract
{
    protected $container;
    protected $listeners = array();
    protected $wildcards = array();
    protected $sorted = array();
    protected $firing = array();
    public function __construct(Container $container = null)
    {
        $this->container = $container ?: new Container();
    }
    public function listen($events, $listener, $priority = 0)
    {
        foreach ((array) $events as $event) {
            if (str_contains($event, '*')) {
                $this->setupWildcardListen($event, $listener);
            } else {
                $this->listeners[$event][$priority][] = $this->makeListener($listener);
                unset($this->sorted[$event]);
            }
        }
    }
    protected function setupWildcardListen($event, $listener)
    {
        $this->wildcards[$event][] = $this->makeListener($listener);
    }
    public function hasListeners($eventName)
    {
        return isset($this->listeners[$eventName]);
    }
    public function queue($event, $payload = array())
    {
        $this->listen($event . '_queue', function () use($event, $payload) {
            $this->fire($event, $payload);
        });
    }
    public function subscribe($subscriber)
    {
        $subscriber = $this->resolveSubscriber($subscriber);
        $subscriber->subscribe($this);
    }
    protected function resolveSubscriber($subscriber)
    {
        if (is_string($subscriber)) {
            return $this->container->make($subscriber);
        }
        return $subscriber;
    }
    public function until($event, $payload = array())
    {
        return $this->fire($event, $payload, true);
    }
    public function flush($event)
    {
        $this->fire($event . '_queue');
    }
    public function firing()
    {
        return last($this->firing);
    }
    public function fire($event, $payload = array(), $halt = false)
    {
        $responses = array();
        if (!is_array($payload)) {
            $payload = array($payload);
        }
        $this->firing[] = $event;
        foreach ($this->getListeners($event) as $listener) {
            $response = call_user_func_array($listener, $payload);
            if (!is_null($response) && $halt) {
                array_pop($this->firing);
                return $response;
            }
            if ($response === false) {
                break;
            }
            $responses[] = $response;
        }
        array_pop($this->firing);
        return $halt ? null : $responses;
    }
    public function getListeners($eventName)
    {
        $wildcards = $this->getWildcardListeners($eventName);
        if (!isset($this->sorted[$eventName])) {
            $this->sortListeners($eventName);
        }
        return array_merge($this->sorted[$eventName], $wildcards);
    }
    protected function getWildcardListeners($eventName)
    {
        $wildcards = array();
        foreach ($this->wildcards as $key => $listeners) {
            if (str_is($key, $eventName)) {
                $wildcards = array_merge($wildcards, $listeners);
            }
        }
        return $wildcards;
    }
    protected function sortListeners($eventName)
    {
        $this->sorted[$eventName] = array();
        if (isset($this->listeners[$eventName])) {
            krsort($this->listeners[$eventName]);
            $this->sorted[$eventName] = call_user_func_array('array_merge', $this->listeners[$eventName]);
        }
    }
    public function makeListener($listener)
    {
        if (is_string($listener)) {
            $listener = $this->createClassListener($listener);
        }
        return $listener;
    }
    public function createClassListener($listener)
    {
        $container = $this->container;
        return function () use($listener, $container) {
            $segments = explode('@', $listener);
            $method = count($segments) == 2 ? $segments[1] : 'handle';
            $callable = array($container->make($segments[0]), $method);
            $data = func_get_args();
            return call_user_func_array($callable, $data);
        };
    }
    public function forget($event)
    {
        unset($this->listeners[$event], $this->sorted[$event]);
    }
    public function forgetQueued()
    {
        foreach ($this->listeners as $key => $value) {
            if (ends_with($key, '_queue')) {
                $this->forget($key);
            }
        }
    }
}
namespace Illuminate\Database\Eloquent;

use DateTime;
use ArrayAccess;
use Carbon\Carbon;
use LogicException;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\ConnectionResolverInterface as Resolver;
abstract class Model implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable
{
    protected $connection;
    protected $table;
    protected $primaryKey = 'id';
    protected $perPage = 15;
    public $incrementing = true;
    public $timestamps = true;
    protected $attributes = array();
    protected $original = array();
    protected $relations = array();
    protected $hidden = array();
    protected $visible = array();
    protected $appends = array();
    protected $fillable = array();
    protected $guarded = array('*');
    protected $dates = array();
    protected $touches = array();
    protected $observables = array();
    protected $with = array();
    protected $morphClass;
    public $exists = false;
    public static $snakeAttributes = true;
    protected static $resolver;
    protected static $dispatcher;
    protected static $booted = array();
    protected static $globalScopes = array();
    protected static $unguarded = false;
    protected static $mutatorCache = array();
    public static $manyMethods = array('belongsToMany', 'morphToMany', 'morphedByMany');
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public function __construct(array $attributes = array())
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
    }
    protected function bootIfNotBooted()
    {
        $class = get_class($this);
        if (!isset(static::$booted[$class])) {
            static::$booted[$class] = true;
            $this->fireModelEvent('booting', false);
            static::boot();
            $this->fireModelEvent('booted', false);
        }
    }
    protected static function boot()
    {
        $class = get_called_class();
        static::$mutatorCache[$class] = array();
        foreach (get_class_methods($class) as $method) {
            if (preg_match('/^get(.+)Attribute$/', $method, $matches)) {
                if (static::$snakeAttributes) {
                    $matches[1] = snake_case($matches[1]);
                }
                static::$mutatorCache[$class][] = lcfirst($matches[1]);
            }
        }
        static::bootTraits();
    }
    protected static function bootTraits()
    {
        foreach (class_uses_recursive(get_called_class()) as $trait) {
            if (method_exists(get_called_class(), $method = 'boot' . class_basename($trait))) {
                forward_static_call(array(get_called_class(), $method));
            }
        }
    }
    public static function addGlobalScope(ScopeInterface $scope)
    {
        static::$globalScopes[get_called_class()][get_class($scope)] = $scope;
    }
    public static function hasGlobalScope($scope)
    {
        return !is_null(static::getGlobalScope($scope));
    }
    public static function getGlobalScope($scope)
    {
        return array_first(static::$globalScopes[get_called_class()], function ($key, $value) use($scope) {
            return $scope instanceof $value;
        });
    }
    public function getGlobalScopes()
    {
        return array_get(static::$globalScopes, get_class($this), array());
    }
    public static function observe($class)
    {
        $instance = new static();
        $className = get_class($class);
        foreach ($instance->getObservableEvents() as $event) {
            if (method_exists($class, $event)) {
                static::registerModelEvent($event, $className . '@' . $event);
            }
        }
    }
    public function fill(array $attributes)
    {
        $totallyGuarded = $this->totallyGuarded();
        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            $key = $this->removeTableFromKey($key);
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            } elseif ($totallyGuarded) {
                throw new MassAssignmentException($key);
            }
        }
        return $this;
    }
    protected function fillableFromArray(array $attributes)
    {
        if (count($this->fillable) > 0 && !static::$unguarded) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }
        return $attributes;
    }
    public function newInstance($attributes = array(), $exists = false)
    {
        $model = new static((array) $attributes);
        $model->exists = $exists;
        return $model;
    }
    public function newFromBuilder($attributes = array())
    {
        $instance = $this->newInstance(array(), true);
        $instance->setRawAttributes((array) $attributes, true);
        return $instance;
    }
    public static function hydrate(array $items, $connection = null)
    {
        $collection = with($instance = new static())->newCollection();
        foreach ($items as $item) {
            $model = $instance->newFromBuilder($item);
            if (!is_null($connection)) {
                $model->setConnection($connection);
            }
            $collection->push($model);
        }
        return $collection;
    }
    public static function hydrateRaw($query, $bindings = array(), $connection = null)
    {
        $instance = new static();
        if (!is_null($connection)) {
            $instance->setConnection($connection);
        }
        $items = $instance->getConnection()->select($query, $bindings);
        return static::hydrate($items, $connection);
    }
    public static function create(array $attributes)
    {
        $model = new static($attributes);
        $model->save();
        return $model;
    }
    public static function firstOrCreate(array $attributes)
    {
        if (!is_null($instance = static::where($attributes)->first())) {
            return $instance;
        }
        return static::create($attributes);
    }
    public static function firstOrNew(array $attributes)
    {
        if (!is_null($instance = static::where($attributes)->first())) {
            return $instance;
        }
        return new static($attributes);
    }
    public static function updateOrCreate(array $attributes, array $values = array())
    {
        $instance = static::firstOrNew($attributes);
        $instance->fill($values)->save();
        return $instance;
    }
    protected static function firstByAttributes($attributes)
    {
        return static::where($attributes)->first();
    }
    public static function query()
    {
        return (new static())->newQuery();
    }
    public static function on($connection = null)
    {
        $instance = new static();
        $instance->setConnection($connection);
        return $instance->newQuery();
    }
    public static function all($columns = array('*'))
    {
        $instance = new static();
        return $instance->newQuery()->get($columns);
    }
    public static function find($id, $columns = array('*'))
    {
        if (is_array($id) && empty($id)) {
            return new Collection();
        }
        $instance = new static();
        return $instance->newQuery()->find($id, $columns);
    }
    public static function findOrNew($id, $columns = array('*'))
    {
        if (!is_null($model = static::find($id, $columns))) {
            return $model;
        }
        return new static();
    }
    public static function findOrFail($id, $columns = array('*'))
    {
        if (!is_null($model = static::find($id, $columns))) {
            return $model;
        }
        throw (new ModelNotFoundException())->setModel(get_called_class());
    }
    public function fresh(array $with = array())
    {
        $key = $this->getKeyName();
        return $this->exists ? static::with($with)->where($key, $this->getKey())->first() : null;
    }
    public function load($relations)
    {
        if (is_string($relations)) {
            $relations = func_get_args();
        }
        $query = $this->newQuery()->with($relations);
        $query->eagerLoadRelations(array($this));
        return $this;
    }
    public static function with($relations)
    {
        if (is_string($relations)) {
            $relations = func_get_args();
        }
        $instance = new static();
        return $instance->newQuery()->with($relations);
    }
    public function hasOne($related, $foreignKey = null, $localKey = null)
    {
        $foreignKey = $foreignKey ?: $this->getForeignKey();
        $instance = new $related();
        $localKey = $localKey ?: $this->getKeyName();
        return new HasOne($instance->newQuery(), $this, $instance->getTable() . '.' . $foreignKey, $localKey);
    }
    public function morphOne($related, $name, $type = null, $id = null, $localKey = null)
    {
        $instance = new $related();
        list($type, $id) = $this->getMorphs($name, $type, $id);
        $table = $instance->getTable();
        $localKey = $localKey ?: $this->getKeyName();
        return new MorphOne($instance->newQuery(), $this, $table . '.' . $type, $table . '.' . $id, $localKey);
    }
    public function belongsTo($related, $foreignKey = null, $otherKey = null, $relation = null)
    {
        if (is_null($relation)) {
            list(, $caller) = debug_backtrace(false);
            $relation = $caller['function'];
        }
        if (is_null($foreignKey)) {
            $foreignKey = snake_case($relation) . '_id';
        }
        $instance = new $related();
        $query = $instance->newQuery();
        $otherKey = $otherKey ?: $instance->getKeyName();
        return new BelongsTo($query, $this, $foreignKey, $otherKey, $relation);
    }
    public function morphTo($name = null, $type = null, $id = null)
    {
        if (is_null($name)) {
            list(, $caller) = debug_backtrace(false);
            $name = snake_case($caller['function']);
        }
        list($type, $id) = $this->getMorphs($name, $type, $id);
        if (is_null($class = $this->{$type})) {
            return new MorphTo($this->newQuery(), $this, $id, null, $type, $name);
        } else {
            $instance = new $class();
            return new MorphTo($instance->newQuery(), $this, $id, $instance->getKeyName(), $type, $name);
        }
    }
    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        $foreignKey = $foreignKey ?: $this->getForeignKey();
        $instance = new $related();
        $localKey = $localKey ?: $this->getKeyName();
        return new HasMany($instance->newQuery(), $this, $instance->getTable() . '.' . $foreignKey, $localKey);
    }
    public function hasManyThrough($related, $through, $firstKey = null, $secondKey = null)
    {
        $through = new $through();
        $firstKey = $firstKey ?: $this->getForeignKey();
        $secondKey = $secondKey ?: $through->getForeignKey();
        return new HasManyThrough((new $related())->newQuery(), $this, $through, $firstKey, $secondKey);
    }
    public function morphMany($related, $name, $type = null, $id = null, $localKey = null)
    {
        $instance = new $related();
        list($type, $id) = $this->getMorphs($name, $type, $id);
        $table = $instance->getTable();
        $localKey = $localKey ?: $this->getKeyName();
        return new MorphMany($instance->newQuery(), $this, $table . '.' . $type, $table . '.' . $id, $localKey);
    }
    public function belongsToMany($related, $table = null, $foreignKey = null, $otherKey = null, $relation = null)
    {
        if (is_null($relation)) {
            $relation = $this->getBelongsToManyCaller();
        }
        $foreignKey = $foreignKey ?: $this->getForeignKey();
        $instance = new $related();
        $otherKey = $otherKey ?: $instance->getForeignKey();
        if (is_null($table)) {
            $table = $this->joiningTable($related);
        }
        $query = $instance->newQuery();
        return new BelongsToMany($query, $this, $table, $foreignKey, $otherKey, $relation);
    }
    public function morphToMany($related, $name, $table = null, $foreignKey = null, $otherKey = null, $inverse = false)
    {
        $caller = $this->getBelongsToManyCaller();
        $foreignKey = $foreignKey ?: $name . '_id';
        $instance = new $related();
        $otherKey = $otherKey ?: $instance->getForeignKey();
        $query = $instance->newQuery();
        $table = $table ?: str_plural($name);
        return new MorphToMany($query, $this, $name, $table, $foreignKey, $otherKey, $caller, $inverse);
    }
    public function morphedByMany($related, $name, $table = null, $foreignKey = null, $otherKey = null)
    {
        $foreignKey = $foreignKey ?: $this->getForeignKey();
        $otherKey = $otherKey ?: $name . '_id';
        return $this->morphToMany($related, $name, $table, $foreignKey, $otherKey, true);
    }
    protected function getBelongsToManyCaller()
    {
        $self = __FUNCTION__;
        $caller = array_first(debug_backtrace(false), function ($key, $trace) use($self) {
            $caller = $trace['function'];
            return !in_array($caller, Model::$manyMethods) && $caller != $self;
        });
        return !is_null($caller) ? $caller['function'] : null;
    }
    public function joiningTable($related)
    {
        $base = snake_case(class_basename($this));
        $related = snake_case(class_basename($related));
        $models = array($related, $base);
        sort($models);
        return strtolower(implode('_', $models));
    }
    public static function destroy($ids)
    {
        $count = 0;
        $ids = is_array($ids) ? $ids : func_get_args();
        $instance = new static();
        $key = $instance->getKeyName();
        foreach ($instance->whereIn($key, $ids)->get() as $model) {
            if ($model->delete()) {
                $count++;
            }
        }
        return $count;
    }
    public function delete()
    {
        if (is_null($this->primaryKey)) {
            throw new \Exception('No primary key defined on model.');
        }
        if ($this->exists) {
            if ($this->fireModelEvent('deleting') === false) {
                return false;
            }
            $this->touchOwners();
            $this->performDeleteOnModel();
            $this->exists = false;
            $this->fireModelEvent('deleted', false);
            return true;
        }
    }
    public function forceDelete()
    {
        return $this->delete();
    }
    protected function performDeleteOnModel()
    {
        $this->newQuery()->where($this->getKeyName(), $this->getKey())->delete();
    }
    public static function saving($callback, $priority = 0)
    {
        static::registerModelEvent('saving', $callback, $priority);
    }
    public static function saved($callback, $priority = 0)
    {
        static::registerModelEvent('saved', $callback, $priority);
    }
    public static function updating($callback, $priority = 0)
    {
        static::registerModelEvent('updating', $callback, $priority);
    }
    public static function updated($callback, $priority = 0)
    {
        static::registerModelEvent('updated', $callback, $priority);
    }
    public static function creating($callback, $priority = 0)
    {
        static::registerModelEvent('creating', $callback, $priority);
    }
    public static function created($callback, $priority = 0)
    {
        static::registerModelEvent('created', $callback, $priority);
    }
    public static function deleting($callback, $priority = 0)
    {
        static::registerModelEvent('deleting', $callback, $priority);
    }
    public static function deleted($callback, $priority = 0)
    {
        static::registerModelEvent('deleted', $callback, $priority);
    }
    public static function flushEventListeners()
    {
        if (!isset(static::$dispatcher)) {
            return;
        }
        $instance = new static();
        foreach ($instance->getObservableEvents() as $event) {
            static::$dispatcher->forget("eloquent.{$event}: " . get_called_class());
        }
    }
    protected static function registerModelEvent($event, $callback, $priority = 0)
    {
        if (isset(static::$dispatcher)) {
            $name = get_called_class();
            static::$dispatcher->listen("eloquent.{$event}: {$name}", $callback, $priority);
        }
    }
    public function getObservableEvents()
    {
        return array_merge(array('creating', 'created', 'updating', 'updated', 'deleting', 'deleted', 'saving', 'saved', 'restoring', 'restored'), $this->observables);
    }
    public function setObservableEvents(array $observables)
    {
        $this->observables = $observables;
    }
    public function addObservableEvents($observables)
    {
        $observables = is_array($observables) ? $observables : func_get_args();
        $this->observables = array_unique(array_merge($this->observables, $observables));
    }
    public function removeObservableEvents($observables)
    {
        $observables = is_array($observables) ? $observables : func_get_args();
        $this->observables = array_diff($this->observables, $observables);
    }
    protected function increment($column, $amount = 1)
    {
        return $this->incrementOrDecrement($column, $amount, 'increment');
    }
    protected function decrement($column, $amount = 1)
    {
        return $this->incrementOrDecrement($column, $amount, 'decrement');
    }
    protected function incrementOrDecrement($column, $amount, $method)
    {
        $query = $this->newQuery();
        if (!$this->exists) {
            return $query->{$method}($column, $amount);
        }
        $this->incrementOrDecrementAttributeValue($column, $amount, $method);
        return $query->where($this->getKeyName(), $this->getKey())->{$method}($column, $amount);
    }
    protected function incrementOrDecrementAttributeValue($column, $amount, $method)
    {
        $this->{$column} = $this->{$column} + ($method == 'increment' ? $amount : $amount * -1);
        $this->syncOriginalAttribute($column);
    }
    public function update(array $attributes = array())
    {
        if (!$this->exists) {
            return $this->newQuery()->update($attributes);
        }
        return $this->fill($attributes)->save();
    }
    public function push()
    {
        if (!$this->save()) {
            return false;
        }
        foreach ($this->relations as $models) {
            foreach (Collection::make($models) as $model) {
                if (!$model->push()) {
                    return false;
                }
            }
        }
        return true;
    }
    public function save(array $options = array())
    {
        $query = $this->newQueryWithoutScopes();
        if ($this->fireModelEvent('saving') === false) {
            return false;
        }
        if ($this->exists) {
            $saved = $this->performUpdate($query, $options);
        } else {
            $saved = $this->performInsert($query, $options);
        }
        if ($saved) {
            $this->finishSave($options);
        }
        return $saved;
    }
    protected function finishSave(array $options)
    {
        $this->fireModelEvent('saved', false);
        $this->syncOriginal();
        if (array_get($options, 'touch', true)) {
            $this->touchOwners();
        }
    }
    protected function performUpdate(Builder $query, array $options)
    {
        $dirty = $this->getDirty();
        if (count($dirty) > 0) {
            if ($this->fireModelEvent('updating') === false) {
                return false;
            }
            if ($this->timestamps && array_get($options, 'timestamps', true)) {
                $this->updateTimestamps();
            }
            $dirty = $this->getDirty();
            if (count($dirty) > 0) {
                $this->setKeysForSaveQuery($query)->update($dirty);
                $this->fireModelEvent('updated', false);
            }
        }
        return true;
    }
    protected function performInsert(Builder $query, array $options)
    {
        if ($this->fireModelEvent('creating') === false) {
            return false;
        }
        if ($this->timestamps && array_get($options, 'timestamps', true)) {
            $this->updateTimestamps();
        }
        $attributes = $this->attributes;
        if ($this->incrementing) {
            $this->insertAndSetId($query, $attributes);
        } else {
            $query->insert($attributes);
        }
        $this->exists = true;
        $this->fireModelEvent('created', false);
        return true;
    }
    protected function insertAndSetId(Builder $query, $attributes)
    {
        $id = $query->insertGetId($attributes, $keyName = $this->getKeyName());
        $this->setAttribute($keyName, $id);
    }
    public function touchOwners()
    {
        foreach ($this->touches as $relation) {
            $this->{$relation}()->touch();
            if (!is_null($this->{$relation})) {
                $this->{$relation}->touchOwners();
            }
        }
    }
    public function touches($relation)
    {
        return in_array($relation, $this->touches);
    }
    protected function fireModelEvent($event, $halt = true)
    {
        if (!isset(static::$dispatcher)) {
            return true;
        }
        $event = "eloquent.{$event}: " . get_class($this);
        $method = $halt ? 'until' : 'fire';
        return static::$dispatcher->{$method}($event, $this);
    }
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query->where($this->getKeyName(), '=', $this->getKeyForSaveQuery());
        return $query;
    }
    protected function getKeyForSaveQuery()
    {
        if (isset($this->original[$this->getKeyName()])) {
            return $this->original[$this->getKeyName()];
        }
        return $this->getAttribute($this->getKeyName());
    }
    public function touch()
    {
        $this->updateTimestamps();
        return $this->save();
    }
    protected function updateTimestamps()
    {
        $time = $this->freshTimestamp();
        if (!$this->isDirty(static::UPDATED_AT)) {
            $this->setUpdatedAt($time);
        }
        if (!$this->exists && !$this->isDirty(static::CREATED_AT)) {
            $this->setCreatedAt($time);
        }
    }
    public function setCreatedAt($value)
    {
        $this->{static::CREATED_AT} = $value;
    }
    public function setUpdatedAt($value)
    {
        $this->{static::UPDATED_AT} = $value;
    }
    public function getCreatedAtColumn()
    {
        return static::CREATED_AT;
    }
    public function getUpdatedAtColumn()
    {
        return static::UPDATED_AT;
    }
    public function freshTimestamp()
    {
        return new Carbon();
    }
    public function freshTimestampString()
    {
        return $this->fromDateTime($this->freshTimestamp());
    }
    public function newQuery()
    {
        $builder = $this->newEloquentBuilder($this->newBaseQueryBuilder());
        $builder->setModel($this)->with($this->with);
        return $this->applyGlobalScopes($builder);
    }
    public function newQueryWithoutScope($scope)
    {
        $this->getGlobalScope($scope)->remove($builder = $this->newQuery(), $this);
        return $builder;
    }
    public function newQueryWithoutScopes()
    {
        return $this->removeGlobalScopes($this->newQuery());
    }
    public function applyGlobalScopes($builder)
    {
        foreach ($this->getGlobalScopes() as $scope) {
            $scope->apply($builder, $this);
        }
        return $builder;
    }
    public function removeGlobalScopes($builder)
    {
        foreach ($this->getGlobalScopes() as $scope) {
            $scope->remove($builder, $this);
        }
        return $builder;
    }
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
    protected function newBaseQueryBuilder()
    {
        $conn = $this->getConnection();
        $grammar = $conn->getQueryGrammar();
        return new QueryBuilder($conn, $grammar, $conn->getPostProcessor());
    }
    public function newCollection(array $models = array())
    {
        return new Collection($models);
    }
    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        return new Pivot($parent, $attributes, $table, $exists);
    }
    public function getTable()
    {
        if (isset($this->table)) {
            return $this->table;
        }
        return str_replace('\\', '', snake_case(str_plural(class_basename($this))));
    }
    public function setTable($table)
    {
        $this->table = $table;
    }
    public function getKey()
    {
        return $this->getAttribute($this->getKeyName());
    }
    public function getQueueableId()
    {
        return $this->getKey();
    }
    public function getKeyName()
    {
        return $this->primaryKey;
    }
    public function setKeyName($key)
    {
        $this->primaryKey = $key;
    }
    public function getQualifiedKeyName()
    {
        return $this->getTable() . '.' . $this->getKeyName();
    }
    public function getRouteKey()
    {
        return $this->getAttribute($this->getRouteKeyName());
    }
    public function getRouteKeyName()
    {
        return $this->getKeyName();
    }
    public function usesTimestamps()
    {
        return $this->timestamps;
    }
    protected function getMorphs($name, $type, $id)
    {
        $type = $type ?: $name . '_type';
        $id = $id ?: $name . '_id';
        return array($type, $id);
    }
    public function getMorphClass()
    {
        return $this->morphClass ?: get_class($this);
    }
    public function getPerPage()
    {
        return $this->perPage;
    }
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }
    public function getForeignKey()
    {
        return snake_case(class_basename($this)) . '_id';
    }
    public function getHidden()
    {
        return $this->hidden;
    }
    public function setHidden(array $hidden)
    {
        $this->hidden = $hidden;
    }
    public function setVisible(array $visible)
    {
        $this->visible = $visible;
    }
    public function setAppends(array $appends)
    {
        $this->appends = $appends;
    }
    public function getFillable()
    {
        return $this->fillable;
    }
    public function fillable(array $fillable)
    {
        $this->fillable = $fillable;
        return $this;
    }
    public function guard(array $guarded)
    {
        $this->guarded = $guarded;
        return $this;
    }
    public static function unguard()
    {
        static::$unguarded = true;
    }
    public static function reguard()
    {
        static::$unguarded = false;
    }
    public static function setUnguardState($state)
    {
        static::$unguarded = $state;
    }
    public function isFillable($key)
    {
        if (static::$unguarded) {
            return true;
        }
        if (in_array($key, $this->fillable)) {
            return true;
        }
        if ($this->isGuarded($key)) {
            return false;
        }
        return empty($this->fillable) && !starts_with($key, '_');
    }
    public function isGuarded($key)
    {
        return in_array($key, $this->guarded) || $this->guarded == array('*');
    }
    public function totallyGuarded()
    {
        return count($this->fillable) == 0 && $this->guarded == array('*');
    }
    protected function removeTableFromKey($key)
    {
        if (!str_contains($key, '.')) {
            return $key;
        }
        return last(explode('.', $key));
    }
    public function getTouchedRelations()
    {
        return $this->touches;
    }
    public function setTouchedRelations(array $touches)
    {
        $this->touches = $touches;
    }
    public function getIncrementing()
    {
        return $this->incrementing;
    }
    public function setIncrementing($value)
    {
        $this->incrementing = $value;
    }
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
    public function jsonSerialize()
    {
        return $this->toArray();
    }
    public function toArray()
    {
        $attributes = $this->attributesToArray();
        return array_merge($attributes, $this->relationsToArray());
    }
    public function attributesToArray()
    {
        $attributes = $this->getArrayableAttributes();
        foreach ($this->getDates() as $key) {
            if (!isset($attributes[$key])) {
                continue;
            }
            $attributes[$key] = (string) $this->asDateTime($attributes[$key]);
        }
        foreach ($this->getMutatedAttributes() as $key) {
            if (!array_key_exists($key, $attributes)) {
                continue;
            }
            $attributes[$key] = $this->mutateAttributeForArray($key, $attributes[$key]);
        }
        foreach ($this->getArrayableAppends() as $key) {
            $attributes[$key] = $this->mutateAttributeForArray($key, null);
        }
        return $attributes;
    }
    protected function getArrayableAttributes()
    {
        return $this->getArrayableItems($this->attributes);
    }
    protected function getArrayableAppends()
    {
        if (!count($this->appends)) {
            return array();
        }
        return $this->getArrayableItems(array_combine($this->appends, $this->appends));
    }
    public function relationsToArray()
    {
        $attributes = array();
        foreach ($this->getArrayableRelations() as $key => $value) {
            if (in_array($key, $this->hidden)) {
                continue;
            }
            if ($value instanceof Arrayable) {
                $relation = $value->toArray();
            } elseif (is_null($value)) {
                $relation = $value;
            }
            if (static::$snakeAttributes) {
                $key = snake_case($key);
            }
            if (isset($relation) || is_null($value)) {
                $attributes[$key] = $relation;
            }
        }
        return $attributes;
    }
    protected function getArrayableRelations()
    {
        return $this->getArrayableItems($this->relations);
    }
    protected function getArrayableItems(array $values)
    {
        if (count($this->visible) > 0) {
            return array_intersect_key($values, array_flip($this->visible));
        }
        return array_diff_key($values, array_flip($this->hidden));
    }
    public function getAttribute($key)
    {
        $inAttributes = array_key_exists($key, $this->attributes);
        if ($inAttributes || $this->hasGetMutator($key)) {
            return $this->getAttributeValue($key);
        }
        if (array_key_exists($key, $this->relations)) {
            return $this->relations[$key];
        }
        $camelKey = camel_case($key);
        if (method_exists($this, $camelKey)) {
            return $this->getRelationshipFromMethod($key, $camelKey);
        }
    }
    protected function getAttributeValue($key)
    {
        $value = $this->getAttributeFromArray($key);
        if ($this->hasGetMutator($key)) {
            return $this->mutateAttribute($key, $value);
        } elseif (in_array($key, $this->getDates())) {
            if ($value) {
                return $this->asDateTime($value);
            }
        }
        return $value;
    }
    protected function getAttributeFromArray($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
    }
    protected function getRelationshipFromMethod($key, $camelKey)
    {
        $relations = $this->{$camelKey}();
        if (!$relations instanceof Relation) {
            throw new LogicException('Relationship method must return an object of type ' . 'Illuminate\\Database\\Eloquent\\Relations\\Relation');
        }
        return $this->relations[$key] = $relations->getResults();
    }
    public function hasGetMutator($key)
    {
        return method_exists($this, 'get' . studly_case($key) . 'Attribute');
    }
    protected function mutateAttribute($key, $value)
    {
        return $this->{'get' . studly_case($key) . 'Attribute'}($value);
    }
    protected function mutateAttributeForArray($key, $value)
    {
        $value = $this->mutateAttribute($key, $value);
        return $value instanceof Arrayable ? $value->toArray() : $value;
    }
    public function setAttribute($key, $value)
    {
        if ($this->hasSetMutator($key)) {
            $method = 'set' . studly_case($key) . 'Attribute';
            return $this->{$method}($value);
        } elseif (in_array($key, $this->getDates()) && $value) {
            $value = $this->fromDateTime($value);
        }
        $this->attributes[$key] = $value;
    }
    public function hasSetMutator($key)
    {
        return method_exists($this, 'set' . studly_case($key) . 'Attribute');
    }
    public function getDates()
    {
        $defaults = array(static::CREATED_AT, static::UPDATED_AT);
        return array_merge($this->dates, $defaults);
    }
    public function fromDateTime($value)
    {
        $format = $this->getDateFormat();
        if ($value instanceof DateTime) {
            
        } elseif (is_numeric($value)) {
            $value = Carbon::createFromTimestamp($value);
        } elseif (preg_match('/^(\\d{4})-(\\d{2})-(\\d{2})$/', $value)) {
            $value = Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
        } else {
            $value = Carbon::createFromFormat($format, $value);
        }
        return $value->format($format);
    }
    protected function asDateTime($value)
    {
        if (is_numeric($value)) {
            return Carbon::createFromTimestamp($value);
        } elseif (preg_match('/^(\\d{4})-(\\d{2})-(\\d{2})$/', $value)) {
            return Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
        } elseif (!$value instanceof DateTime) {
            $format = $this->getDateFormat();
            return Carbon::createFromFormat($format, $value);
        }
        return Carbon::instance($value);
    }
    protected function getDateFormat()
    {
        return $this->getConnection()->getQueryGrammar()->getDateFormat();
    }
    public function replicate(array $except = null)
    {
        $except = $except ?: array($this->getKeyName(), $this->getCreatedAtColumn(), $this->getUpdatedAtColumn());
        $attributes = array_except($this->attributes, $except);
        with($instance = new static())->setRawAttributes($attributes);
        return $instance->setRelations($this->relations);
    }
    public function getAttributes()
    {
        return $this->attributes;
    }
    public function setRawAttributes(array $attributes, $sync = false)
    {
        $this->attributes = $attributes;
        if ($sync) {
            $this->syncOriginal();
        }
    }
    public function getOriginal($key = null, $default = null)
    {
        return array_get($this->original, $key, $default);
    }
    public function syncOriginal()
    {
        $this->original = $this->attributes;
        return $this;
    }
    public function syncOriginalAttribute($attribute)
    {
        $this->original[$attribute] = $this->attributes[$attribute];
        return $this;
    }
    public function isDirty($attributes = null)
    {
        $dirty = $this->getDirty();
        if (is_null($attributes)) {
            return count($dirty) > 0;
        }
        if (!is_array($attributes)) {
            $attributes = func_get_args();
        }
        foreach ($attributes as $attribute) {
            if (array_key_exists($attribute, $dirty)) {
                return true;
            }
        }
        return false;
    }
    public function getDirty()
    {
        $dirty = array();
        foreach ($this->attributes as $key => $value) {
            if (!array_key_exists($key, $this->original)) {
                $dirty[$key] = $value;
            } elseif ($value !== $this->original[$key] && !$this->originalIsNumericallyEquivalent($key)) {
                $dirty[$key] = $value;
            }
        }
        return $dirty;
    }
    protected function originalIsNumericallyEquivalent($key)
    {
        $current = $this->attributes[$key];
        $original = $this->original[$key];
        return is_numeric($current) && is_numeric($original) && strcmp((string) $current, (string) $original) === 0;
    }
    public function getRelations()
    {
        return $this->relations;
    }
    public function getRelation($relation)
    {
        return $this->relations[$relation];
    }
    public function setRelation($relation, $value)
    {
        $this->relations[$relation] = $value;
        return $this;
    }
    public function setRelations(array $relations)
    {
        $this->relations = $relations;
        return $this;
    }
    public function getConnection()
    {
        return static::resolveConnection($this->connection);
    }
    public function getConnectionName()
    {
        return $this->connection;
    }
    public function setConnection($name)
    {
        $this->connection = $name;
        return $this;
    }
    public static function resolveConnection($connection = null)
    {
        return static::$resolver->connection($connection);
    }
    public static function getConnectionResolver()
    {
        return static::$resolver;
    }
    public static function setConnectionResolver(Resolver $resolver)
    {
        static::$resolver = $resolver;
    }
    public static function unsetConnectionResolver()
    {
        static::$resolver = null;
    }
    public static function getEventDispatcher()
    {
        return static::$dispatcher;
    }
    public static function setEventDispatcher(Dispatcher $dispatcher)
    {
        static::$dispatcher = $dispatcher;
    }
    public static function unsetEventDispatcher()
    {
        static::$dispatcher = null;
    }
    public function getMutatedAttributes()
    {
        $class = get_class($this);
        if (isset(static::$mutatorCache[$class])) {
            return static::$mutatorCache[$class];
        }
        return array();
    }
    public function __get($key)
    {
        return $this->getAttribute($key);
    }
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }
    public function offsetExists($offset)
    {
        return isset($this->{$offset});
    }
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }
    public function __isset($key)
    {
        return isset($this->attributes[$key]) || isset($this->relations[$key]) || $this->hasGetMutator($key) && !is_null($this->getAttributeValue($key));
    }
    public function __unset($key)
    {
        unset($this->attributes[$key], $this->relations[$key]);
    }
    public function __call($method, $parameters)
    {
        if (in_array($method, array('increment', 'decrement'))) {
            return call_user_func_array(array($this, $method), $parameters);
        }
        $query = $this->newQuery();
        return call_user_func_array(array($query, $method), $parameters);
    }
    public static function __callStatic($method, $parameters)
    {
        $instance = new static();
        return call_user_func_array(array($instance, $method), $parameters);
    }
    public function __toString()
    {
        return $this->toJson();
    }
    public function __wakeup()
    {
        $this->bootIfNotBooted();
    }
}
namespace Illuminate\Database;

use Illuminate\Support\Str;
use Illuminate\Database\Connectors\ConnectionFactory;
class DatabaseManager implements ConnectionResolverInterface
{
    protected $app;
    protected $factory;
    protected $connections = array();
    protected $extensions = array();
    public function __construct($app, ConnectionFactory $factory)
    {
        $this->app = $app;
        $this->factory = $factory;
    }
    public function connection($name = null)
    {
        list($name, $type) = $this->parseConnectionName($name);
        if (!isset($this->connections[$name])) {
            $connection = $this->makeConnection($name);
            $this->setPdoForType($connection, $type);
            $this->connections[$name] = $this->prepare($connection);
        }
        return $this->connections[$name];
    }
    protected function parseConnectionName($name)
    {
        $name = $name ?: $this->getDefaultConnection();
        return Str::endsWith($name, array('::read', '::write')) ? explode('::', $name, 2) : array($name, null);
    }
    public function purge($name = null)
    {
        $this->disconnect($name);
        unset($this->connections[$name]);
    }
    public function disconnect($name = null)
    {
        if (isset($this->connections[$name = $name ?: $this->getDefaultConnection()])) {
            $this->connections[$name]->disconnect();
        }
    }
    public function reconnect($name = null)
    {
        $this->disconnect($name = $name ?: $this->getDefaultConnection());
        if (!isset($this->connections[$name])) {
            return $this->connection($name);
        }
        return $this->refreshPdoConnections($name);
    }
    protected function refreshPdoConnections($name)
    {
        $fresh = $this->makeConnection($name);
        return $this->connections[$name]->setPdo($fresh->getPdo())->setReadPdo($fresh->getReadPdo());
    }
    protected function makeConnection($name)
    {
        $config = $this->getConfig($name);
        if (isset($this->extensions[$name])) {
            return call_user_func($this->extensions[$name], $config, $name);
        }
        $driver = $config['driver'];
        if (isset($this->extensions[$driver])) {
            return call_user_func($this->extensions[$driver], $config, $name);
        }
        return $this->factory->make($config, $name);
    }
    protected function prepare(Connection $connection)
    {
        $connection->setFetchMode($this->app['config']['database.fetch']);
        if ($this->app->bound('events')) {
            $connection->setEventDispatcher($this->app['events']);
        }
        $app = $this->app;
        $connection->setReconnector(function ($connection) {
            $this->reconnect($connection->getName());
        });
        return $connection;
    }
    protected function setPdoForType(Connection $connection, $type = null)
    {
        if ($type == 'read') {
            $connection->setPdo($connection->getReadPdo());
        } elseif ($type == 'write') {
            $connection->setReadPdo($connection->getPdo());
        }
        return $connection;
    }
    protected function getConfig($name)
    {
        $name = $name ?: $this->getDefaultConnection();
        $connections = $this->app['config']['database.connections'];
        if (is_null($config = array_get($connections, $name))) {
            throw new \InvalidArgumentException("Database [{$name}] not configured.");
        }
        return $config;
    }
    public function getDefaultConnection()
    {
        return $this->app['config']['database.default'];
    }
    public function setDefaultConnection($name)
    {
        $this->app['config']['database.default'] = $name;
    }
    public function extend($name, callable $resolver)
    {
        $this->extensions[$name] = $resolver;
    }
    public function getConnections()
    {
        return $this->connections;
    }
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->connection(), $method), $parameters);
    }
}
namespace Illuminate\Database;

interface ConnectionResolverInterface
{
    public function connection($name = null);
    public function getDefaultConnection();
    public function setDefaultConnection($name);
}
namespace Illuminate\Database\Connectors;

use PDO;
use Illuminate\Container\Container;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\SqlServerConnection;
class ConnectionFactory
{
    protected $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    public function make(array $config, $name = null)
    {
        $config = $this->parseConfig($config, $name);
        if (isset($config['read'])) {
            return $this->createReadWriteConnection($config);
        }
        return $this->createSingleConnection($config);
    }
    protected function createSingleConnection(array $config)
    {
        $pdo = $this->createConnector($config)->connect($config);
        return $this->createConnection($config['driver'], $pdo, $config['database'], $config['prefix'], $config);
    }
    protected function createReadWriteConnection(array $config)
    {
        $connection = $this->createSingleConnection($this->getWriteConfig($config));
        return $connection->setReadPdo($this->createReadPdo($config));
    }
    protected function createReadPdo(array $config)
    {
        $readConfig = $this->getReadConfig($config);
        return $this->createConnector($readConfig)->connect($readConfig);
    }
    protected function getReadConfig(array $config)
    {
        $readConfig = $this->getReadWriteConfig($config, 'read');
        return $this->mergeReadWriteConfig($config, $readConfig);
    }
    protected function getWriteConfig(array $config)
    {
        $writeConfig = $this->getReadWriteConfig($config, 'write');
        return $this->mergeReadWriteConfig($config, $writeConfig);
    }
    protected function getReadWriteConfig(array $config, $type)
    {
        if (isset($config[$type][0])) {
            return $config[$type][array_rand($config[$type])];
        }
        return $config[$type];
    }
    protected function mergeReadWriteConfig(array $config, array $merge)
    {
        return array_except(array_merge($config, $merge), array('read', 'write'));
    }
    protected function parseConfig(array $config, $name)
    {
        return array_add(array_add($config, 'prefix', ''), 'name', $name);
    }
    public function createConnector(array $config)
    {
        if (!isset($config['driver'])) {
            throw new \InvalidArgumentException('A driver must be specified.');
        }
        if ($this->container->bound($key = "db.connector.{$config['driver']}")) {
            return $this->container->make($key);
        }
        switch ($config['driver']) {
            case 'mysql':
                return new MySqlConnector();
            case 'pgsql':
                return new PostgresConnector();
            case 'sqlite':
                return new SQLiteConnector();
            case 'sqlsrv':
                return new SqlServerConnector();
        }
        throw new \InvalidArgumentException("Unsupported driver [{$config['driver']}]");
    }
    protected function createConnection($driver, PDO $connection, $database, $prefix = '', array $config = array())
    {
        if ($this->container->bound($key = "db.connection.{$driver}")) {
            return $this->container->make($key, array($connection, $database, $prefix, $config));
        }
        switch ($driver) {
            case 'mysql':
                return new MySqlConnection($connection, $database, $prefix, $config);
            case 'pgsql':
                return new PostgresConnection($connection, $database, $prefix, $config);
            case 'sqlite':
                return new SQLiteConnection($connection, $database, $prefix, $config);
            case 'sqlsrv':
                return new SqlServerConnection($connection, $database, $prefix, $config);
        }
        throw new \InvalidArgumentException("Unsupported driver [{$driver}]");
    }
}
namespace Illuminate\Session;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface as BaseSessionInterface;
interface SessionInterface extends BaseSessionInterface
{
    public function getHandler();
    public function handlerNeedsRequest();
    public function setRequestOnHandler(Request $request);
}
namespace Illuminate\Session\Middleware;

use Closure;
use Illuminate\Session\SessionManager;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Contracts\Routing\Middleware as MiddlewareContract;
class Reader implements MiddlewareContract
{
    use MiddlewareTrait;
    protected $manager;
    public function __construct(SessionManager $manager)
    {
        $this->manager = $manager;
    }
    public function handle($request, Closure $next)
    {
        if ($this->sessionConfigured()) {
            $session = $this->startSession($request);
            $request->setSession($session);
        }
        return $next($request);
    }
    protected function startSession(Request $request)
    {
        with($session = $this->getSession($request))->setRequestOnHandler($request);
        $session->start();
        return $session;
    }
    public function getSession(Request $request)
    {
        $session = $this->manager->driver();
        $session->setId($request->cookies->get($session->getName()));
        return $session;
    }
}
namespace Illuminate\Session\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Session\SessionManager;
use Illuminate\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Routing\Middleware as MiddlewareContract;
class Writer implements MiddlewareContract
{
    use MiddlewareTrait;
    protected $manager;
    public function __construct(SessionManager $manager)
    {
        $this->manager = $manager;
    }
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if ($this->sessionConfigured()) {
            with($session = $this->getSession())->save();
            $this->collectGarbage($session);
            $this->addCookieToResponse($response, $session);
        }
        return $response;
    }
    protected function collectGarbage(SessionInterface $session)
    {
        $config = $this->manager->getSessionConfig();
        if ($this->configHitsLottery($config)) {
            $session->getHandler()->gc($this->getSessionLifetimeInSeconds());
        }
    }
    protected function configHitsLottery(array $config)
    {
        return mt_rand(1, $config['lottery'][1]) <= $config['lottery'][0];
    }
    protected function addCookieToResponse(Response $response, SessionInterface $session)
    {
        if ($this->sessionIsPersistent($config = $this->manager->getSessionConfig())) {
            $response->headers->setCookie(new Cookie($session->getName(), $session->getId(), $this->getCookieExpirationDate(), $config['path'], $config['domain'], array_get($config, 'secure', false)));
        }
    }
    protected function getSessionLifetimeInSeconds()
    {
        return array_get($this->manager->getSessionConfig(), 'lifetime') * 60;
    }
    protected function getCookieExpirationDate()
    {
        $config = $this->manager->getSessionConfig();
        return $config['expire_on_close'] ? 0 : Carbon::now()->addMinutes($config['lifetime']);
    }
    public function getSession()
    {
        return $this->manager->driver();
    }
}
namespace Illuminate\Session;

use SessionHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;
class Store implements SessionInterface
{
    protected $id;
    protected $name;
    protected $attributes = array();
    protected $bags = array();
    protected $metaBag;
    protected $bagData = array();
    protected $handler;
    protected $started = false;
    public function __construct($name, SessionHandlerInterface $handler, $id = null)
    {
        $this->setId($id);
        $this->name = $name;
        $this->handler = $handler;
        $this->metaBag = new MetadataBag();
    }
    public function start()
    {
        $this->loadSession();
        if (!$this->has('_token')) {
            $this->regenerateToken();
        }
        return $this->started = true;
    }
    protected function loadSession()
    {
        $this->attributes = $this->readFromHandler();
        foreach (array_merge($this->bags, array($this->metaBag)) as $bag) {
            $this->initializeLocalBag($bag);
            $bag->initialize($this->bagData[$bag->getStorageKey()]);
        }
    }
    protected function readFromHandler()
    {
        $data = $this->handler->read($this->getId());
        return $data ? unserialize($data) : array();
    }
    protected function initializeLocalBag($bag)
    {
        $this->bagData[$bag->getStorageKey()] = $this->pull($bag->getStorageKey(), array());
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        if (!$this->isValidId($id)) {
            $id = $this->generateSessionId();
        }
        $this->id = $id;
    }
    public function isValidId($id)
    {
        return is_string($id) && preg_match('/^[a-f0-9]{40}$/', $id);
    }
    protected function generateSessionId()
    {
        return sha1(uniqid('', true) . str_random(25) . microtime(true));
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function invalidate($lifetime = null)
    {
        $this->attributes = array();
        $this->migrate();
        return true;
    }
    public function migrate($destroy = false, $lifetime = null)
    {
        if ($destroy) {
            $this->handler->destroy($this->getId());
        }
        $this->setExists(false);
        $this->id = $this->generateSessionId();
        return true;
    }
    public function regenerate($destroy = false)
    {
        return $this->migrate($destroy);
    }
    public function save()
    {
        $this->addBagDataToSession();
        $this->ageFlashData();
        $this->handler->write($this->getId(), serialize($this->attributes));
        $this->started = false;
    }
    protected function addBagDataToSession()
    {
        foreach (array_merge($this->bags, array($this->metaBag)) as $bag) {
            $this->put($bag->getStorageKey(), $this->bagData[$bag->getStorageKey()]);
        }
    }
    public function ageFlashData()
    {
        foreach ($this->get('flash.old', array()) as $old) {
            $this->forget($old);
        }
        $this->put('flash.old', $this->get('flash.new', array()));
        $this->put('flash.new', array());
    }
    public function has($name)
    {
        return !is_null($this->get($name));
    }
    public function get($name, $default = null)
    {
        return array_get($this->attributes, $name, $default);
    }
    public function pull($key, $default = null)
    {
        return array_pull($this->attributes, $key, $default);
    }
    public function hasOldInput($key = null)
    {
        $old = $this->getOldInput($key);
        return is_null($key) ? count($old) > 0 : !is_null($old);
    }
    public function getOldInput($key = null, $default = null)
    {
        $input = $this->get('_old_input', array());
        return array_get($input, $key, $default);
    }
    public function set($name, $value)
    {
        array_set($this->attributes, $name, $value);
    }
    public function put($key, $value = null)
    {
        if (!is_array($key)) {
            $key = array($key => $value);
        }
        foreach ($key as $arrayKey => $arrayValue) {
            $this->set($arrayKey, $arrayValue);
        }
    }
    public function push($key, $value)
    {
        $array = $this->get($key, array());
        $array[] = $value;
        $this->put($key, $array);
    }
    public function flash($key, $value)
    {
        $this->put($key, $value);
        $this->push('flash.new', $key);
        $this->removeFromOldFlashData(array($key));
    }
    public function flashInput(array $value)
    {
        $this->flash('_old_input', $value);
    }
    public function reflash()
    {
        $this->mergeNewFlashes($this->get('flash.old', array()));
        $this->put('flash.old', array());
    }
    public function keep($keys = null)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        $this->mergeNewFlashes($keys);
        $this->removeFromOldFlashData($keys);
    }
    protected function mergeNewFlashes(array $keys)
    {
        $values = array_unique(array_merge($this->get('flash.new', array()), $keys));
        $this->put('flash.new', $values);
    }
    protected function removeFromOldFlashData(array $keys)
    {
        $this->put('flash.old', array_diff($this->get('flash.old', array()), $keys));
    }
    public function all()
    {
        return $this->attributes;
    }
    public function replace(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->put($key, $value);
        }
    }
    public function remove($name)
    {
        return array_pull($this->attributes, $name);
    }
    public function forget($key)
    {
        array_forget($this->attributes, $key);
    }
    public function clear()
    {
        $this->attributes = array();
        foreach ($this->bags as $bag) {
            $bag->clear();
        }
    }
    public function flush()
    {
        $this->clear();
    }
    public function isStarted()
    {
        return $this->started;
    }
    public function registerBag(SessionBagInterface $bag)
    {
        $this->bags[$bag->getStorageKey()] = $bag;
    }
    public function getBag($name)
    {
        return array_get($this->bags, $name, function () {
            throw new \InvalidArgumentException('Bag not registered.');
        });
    }
    public function getMetadataBag()
    {
        return $this->metaBag;
    }
    public function getBagData($name)
    {
        return array_get($this->bagData, $name, array());
    }
    public function token()
    {
        return $this->get('_token');
    }
    public function getToken()
    {
        return $this->token();
    }
    public function regenerateToken()
    {
        $this->put('_token', str_random(40));
    }
    public function setExists($value)
    {
        if ($this->handler instanceof ExistenceAwareInterface) {
            $this->handler->setExists($value);
        }
    }
    public function getHandler()
    {
        return $this->handler;
    }
    public function handlerNeedsRequest()
    {
        return $this->handler instanceof CookieSessionHandler;
    }
    public function setRequestOnHandler(Request $request)
    {
        if ($this->handlerNeedsRequest()) {
            $this->handler->setRequest($request);
        }
    }
}
namespace Illuminate\Session;

use Illuminate\Support\Manager;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NullSessionHandler;
class SessionManager extends Manager
{
    protected function callCustomCreator($driver)
    {
        return $this->buildSession(parent::callCustomCreator($driver));
    }
    protected function createArrayDriver()
    {
        return new Store($this->app['config']['session.cookie'], new NullSessionHandler());
    }
    protected function createCookieDriver()
    {
        $lifetime = $this->app['config']['session.lifetime'];
        return $this->buildSession(new CookieSessionHandler($this->app['cookie'], $lifetime));
    }
    protected function createFileDriver()
    {
        return $this->createNativeDriver();
    }
    protected function createNativeDriver()
    {
        $path = $this->app['config']['session.files'];
        return $this->buildSession(new FileSessionHandler($this->app['files'], $path));
    }
    protected function createDatabaseDriver()
    {
        $connection = $this->getDatabaseConnection();
        $table = $this->app['config']['session.table'];
        return $this->buildSession(new DatabaseSessionHandler($connection, $table));
    }
    protected function getDatabaseConnection()
    {
        $connection = $this->app['config']['session.connection'];
        return $this->app['db']->connection($connection);
    }
    protected function createApcDriver()
    {
        return $this->createCacheBased('apc');
    }
    protected function createMemcachedDriver()
    {
        return $this->createCacheBased('memcached');
    }
    protected function createWincacheDriver()
    {
        return $this->createCacheBased('wincache');
    }
    protected function createRedisDriver()
    {
        $handler = $this->createCacheHandler('redis');
        $handler->getCache()->getStore()->setConnection($this->app['config']['session.connection']);
        return $this->buildSession($handler);
    }
    protected function createCacheBased($driver)
    {
        return $this->buildSession($this->createCacheHandler($driver));
    }
    protected function createCacheHandler($driver)
    {
        $minutes = $this->app['config']['session.lifetime'];
        return new CacheBasedSessionHandler($this->app['cache']->driver($driver), $minutes);
    }
    protected function buildSession($handler)
    {
        return new Store($this->app['config']['session.cookie'], $handler);
    }
    public function getSessionConfig()
    {
        return $this->app['config']['session'];
    }
    public function getDefaultDriver()
    {
        return $this->app['config']['session.driver'];
    }
    public function setDefaultDriver($name)
    {
        $this->app['config']['session.driver'] = $name;
    }
}
namespace Illuminate\Support;

use Closure;
abstract class Manager
{
    protected $app;
    protected $customCreators = array();
    protected $drivers = array();
    public function __construct($app)
    {
        $this->app = $app;
    }
    public abstract function getDefaultDriver();
    public function driver($driver = null)
    {
        $driver = $driver ?: $this->getDefaultDriver();
        if (!isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }
        return $this->drivers[$driver];
    }
    protected function createDriver($driver)
    {
        $method = 'create' . ucfirst($driver) . 'Driver';
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        } elseif (method_exists($this, $method)) {
            return $this->{$method}();
        }
        throw new \InvalidArgumentException("Driver [{$driver}] not supported.");
    }
    protected function callCustomCreator($driver)
    {
        return $this->customCreators[$driver]($this->app);
    }
    public function extend($driver, Closure $callback)
    {
        $this->customCreators[$driver] = $callback;
        return $this;
    }
    public function getDrivers()
    {
        return $this->drivers;
    }
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->driver(), $method), $parameters);
    }
}
namespace Illuminate\Cookie;

use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Contracts\Cookie\QueueingFactory as JarContract;
class CookieJar implements JarContract
{
    protected $path = '/';
    protected $domain = null;
    protected $queued = array();
    public function make($name, $value, $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = true)
    {
        list($path, $domain) = $this->getPathAndDomain($path, $domain);
        $time = $minutes == 0 ? 0 : time() + $minutes * 60;
        return new Cookie($name, $value, $time, $path, $domain, $secure, $httpOnly);
    }
    public function forever($name, $value, $path = null, $domain = null, $secure = false, $httpOnly = true)
    {
        return $this->make($name, $value, 2628000, $path, $domain, $secure, $httpOnly);
    }
    public function forget($name, $path = null, $domain = null)
    {
        return $this->make($name, null, -2628000, $path, $domain);
    }
    public function hasQueued($key)
    {
        return !is_null($this->queued($key));
    }
    public function queued($key, $default = null)
    {
        return array_get($this->queued, $key, $default);
    }
    public function queue()
    {
        if (head(func_get_args()) instanceof Cookie) {
            $cookie = head(func_get_args());
        } else {
            $cookie = call_user_func_array(array($this, 'make'), func_get_args());
        }
        $this->queued[$cookie->getName()] = $cookie;
    }
    public function unqueue($name)
    {
        unset($this->queued[$name]);
    }
    protected function getPathAndDomain($path, $domain)
    {
        return array($path ?: $this->path, $domain ?: $this->domain);
    }
    public function setDefaultPathAndDomain($path, $domain)
    {
        list($this->path, $this->domain) = array($path, $domain);
        return $this;
    }
    public function getQueuedCookies()
    {
        return $this->queued;
    }
}
namespace Illuminate\Cookie\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Contracts\Routing\Middleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
class Guard implements Middleware
{
    protected $encrypter;
    public function __construct(EncrypterContract $encrypter)
    {
        $this->encrypter = $encrypter;
    }
    public function handle($request, Closure $next)
    {
        return $this->encrypt($next($this->decrypt($request)));
    }
    protected function decrypt(Request $request)
    {
        foreach ($request->cookies as $key => $c) {
            try {
                $request->cookies->set($key, $this->decryptCookie($c));
            } catch (DecryptException $e) {
                $request->cookies->set($key, null);
            }
        }
        return $request;
    }
    protected function decryptCookie($cookie)
    {
        return is_array($cookie) ? $this->decryptArray($cookie) : $this->encrypter->decrypt($cookie);
    }
    protected function decryptArray(array $cookie)
    {
        $decrypted = array();
        foreach ($cookie as $key => $value) {
            $decrypted[$key] = $this->encrypter->decrypt($value);
        }
        return $decrypted;
    }
    protected function encrypt(Response $response)
    {
        foreach ($response->headers->getCookies() as $key => $cookie) {
            $response->headers->setCookie($this->duplicate($cookie, $this->encrypter->encrypt($cookie->getValue())));
        }
        return $response;
    }
    protected function duplicate(Cookie $c, $value)
    {
        return new Cookie($c->getName(), $value, $c->getExpiresTime(), $c->getPath(), $c->getDomain(), $c->isSecure(), $c->isHttpOnly());
    }
}
namespace Illuminate\Cookie\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Contracts\Cookie\QueueingFactory as CookieJar;
class Queue implements Middleware
{
    protected $cookies;
    public function __construct(CookieJar $cookies)
    {
        $this->cookies = $cookies;
    }
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        foreach ($this->cookies->getQueuedCookies() as $cookie) {
            $response->headers->setCookie($cookie);
        }
        return $response;
    }
}
namespace Illuminate\Encryption;

use Illuminate\Contracts\Encryption\DecryptException;
use Symfony\Component\Security\Core\Util\StringUtils;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
class Encrypter implements EncrypterContract
{
    protected $key;
    protected $cipher = MCRYPT_RIJNDAEL_128;
    protected $mode = MCRYPT_MODE_CBC;
    protected $block = 16;
    public function __construct($key)
    {
        $this->key = $key;
    }
    public function encrypt($value)
    {
        $iv = mcrypt_create_iv($this->getIvSize(), $this->getRandomizer());
        $value = base64_encode($this->padAndMcrypt($value, $iv));
        $mac = $this->hash($iv = base64_encode($iv), $value);
        return base64_encode(json_encode(compact('iv', 'value', 'mac')));
    }
    protected function padAndMcrypt($value, $iv)
    {
        $value = $this->addPadding(serialize($value));
        return mcrypt_encrypt($this->cipher, $this->key, $value, $this->mode, $iv);
    }
    public function decrypt($payload)
    {
        $payload = $this->getJsonPayload($payload);
        $value = base64_decode($payload['value']);
        $iv = base64_decode($payload['iv']);
        return unserialize($this->stripPadding($this->mcryptDecrypt($value, $iv)));
    }
    protected function mcryptDecrypt($value, $iv)
    {
        try {
            return mcrypt_decrypt($this->cipher, $this->key, $value, $this->mode, $iv);
        } catch (\Exception $e) {
            throw new DecryptException($e->getMessage());
        }
    }
    protected function getJsonPayload($payload)
    {
        $payload = json_decode(base64_decode($payload), true);
        if (!$payload || $this->invalidPayload($payload)) {
            throw new DecryptException('Invalid data.');
        }
        if (!$this->validMac($payload)) {
            throw new DecryptException('MAC is invalid.');
        }
        return $payload;
    }
    protected function validMac(array $payload)
    {
        $bytes = (new SecureRandom())->nextBytes(16);
        $calcMac = hash_hmac('sha256', $this->hash($payload['iv'], $payload['value']), $bytes, true);
        return StringUtils::equals(hash_hmac('sha256', $payload['mac'], $bytes, true), $calcMac);
    }
    protected function hash($iv, $value)
    {
        return hash_hmac('sha256', $iv . $value, $this->key);
    }
    protected function addPadding($value)
    {
        $pad = $this->block - strlen($value) % $this->block;
        return $value . str_repeat(chr($pad), $pad);
    }
    protected function stripPadding($value)
    {
        $pad = ord($value[($len = strlen($value)) - 1]);
        return $this->paddingIsValid($pad, $value) ? substr($value, 0, $len - $pad) : $value;
    }
    protected function paddingIsValid($pad, $value)
    {
        $beforePad = strlen($value) - $pad;
        return substr($value, $beforePad) == str_repeat(substr($value, -1), $pad);
    }
    protected function invalidPayload($data)
    {
        return !is_array($data) || !isset($data['iv']) || !isset($data['value']) || !isset($data['mac']);
    }
    protected function getIvSize()
    {
        return mcrypt_get_iv_size($this->cipher, $this->mode);
    }
    protected function getRandomizer()
    {
        if (defined('MCRYPT_DEV_URANDOM')) {
            return MCRYPT_DEV_URANDOM;
        }
        if (defined('MCRYPT_DEV_RANDOM')) {
            return MCRYPT_DEV_RANDOM;
        }
        mt_srand();
        return MCRYPT_RAND;
    }
    public function setKey($key)
    {
        $this->key = $key;
    }
    public function setCipher($cipher)
    {
        $this->cipher = $cipher;
        $this->updateBlockSize();
    }
    public function setMode($mode)
    {
        $this->mode = $mode;
        $this->updateBlockSize();
    }
    protected function updateBlockSize()
    {
        $this->block = mcrypt_get_iv_size($this->cipher, $this->mode);
    }
}
namespace Illuminate\Support\Facades;

class Log extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'log';
    }
}
namespace Illuminate\Log;

use Monolog\Logger;
use Illuminate\Support\ServiceProvider;
class LogServiceProvider extends ServiceProvider
{
    protected $defer = true;
    public function register()
    {
        $this->app->instance('log', new Writer(new Logger($this->app['env']), $this->app['events']));
        $this->app->bind('Psr\\Log\\LoggerInterface', function () {
            return $this->app['log']->getMonolog();
        });
    }
    public function provides()
    {
        return array('log');
    }
}
namespace Illuminate\Log;

use Closure;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\RotatingFileHandler;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Support\Arrayable;
use Psr\Log\LoggerInterface as PsrLoggerInterface;
use Illuminate\Contracts\Logging\Log as LogContract;
class Writer implements LogContract, PsrLoggerInterface
{
    protected $monolog;
    protected $dispatcher;
    public function __construct(MonologLogger $monolog, Dispatcher $dispatcher = null)
    {
        $this->monolog = $monolog;
        if (isset($dispatcher)) {
            $this->dispatcher = $dispatcher;
        }
    }
    public function emergency($message, array $context = array())
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }
    public function alert($message, array $context = array())
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }
    public function critical($message, array $context = array())
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }
    public function error($message, array $context = array())
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }
    public function warning($message, array $context = array())
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }
    public function notice($message, array $context = array())
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }
    public function info($message, array $context = array())
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }
    public function debug($message, array $context = array())
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }
    public function log($level, $message, array $context = array())
    {
        return $this->writeLog($level, $message, $context);
    }
    public function write($level, $message, array $context = array())
    {
        return $this->log($level, $message, $context);
    }
    protected function writeLog($level, $message, $context)
    {
        $this->fireLogEvent($level, $message = $this->formatMessage($message), $context);
        $this->monolog->{$level}($message, $context);
    }
    public function useFiles($path, $level = 'debug')
    {
        $this->monolog->pushHandler($handler = new StreamHandler($path, $this->parseLevel($level)));
        $handler->setFormatter($this->getDefaultFormatter());
    }
    public function useDailyFiles($path, $days = 0, $level = 'debug')
    {
        $this->monolog->pushHandler($handler = new RotatingFileHandler($path, $days, $this->parseLevel($level)));
        $handler->setFormatter($this->getDefaultFormatter());
    }
    public function useErrorLog($level = 'debug', $messageType = ErrorLogHandler::OPERATING_SYSTEM)
    {
        $this->monolog->pushHandler($handler = new ErrorLogHandler($messageType, $this->parseLevel($level)));
        $handler->setFormatter($this->getDefaultFormatter());
    }
    public function listen(Closure $callback)
    {
        if (!isset($this->dispatcher)) {
            throw new \RuntimeException('Events dispatcher has not been set.');
        }
        $this->dispatcher->listen('illuminate.log', $callback);
    }
    protected function fireLogEvent($level, $message, array $context = array())
    {
        if (isset($this->dispatcher)) {
            $this->dispatcher->fire('illuminate.log', compact('level', 'message', 'context'));
        }
    }
    protected function formatMessage($message)
    {
        if (is_array($message)) {
            return var_export($message, true);
        } elseif ($message instanceof Jsonable) {
            return $message->toJson();
        } elseif ($message instanceof Arrayable) {
            return var_export($message->toArray(), true);
        }
        return $message;
    }
    protected function parseLevel($level)
    {
        switch ($level) {
            case 'debug':
                return MonologLogger::DEBUG;
            case 'info':
                return MonologLogger::INFO;
            case 'notice':
                return MonologLogger::NOTICE;
            case 'warning':
                return MonologLogger::WARNING;
            case 'error':
                return MonologLogger::ERROR;
            case 'critical':
                return MonologLogger::CRITICAL;
            case 'alert':
                return MonologLogger::ALERT;
            case 'emergency':
                return MonologLogger::EMERGENCY;
            default:
                throw new \InvalidArgumentException('Invalid log level.');
        }
    }
    public function getMonolog()
    {
        return $this->monolog;
    }
    protected function getDefaultFormatter()
    {
        return new LineFormatter(null, null, true);
    }
    public function getEventDispatcher()
    {
        return $this->dispatcher;
    }
    public function setEventDispatcher(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}
namespace Monolog;

use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;
use Psr\Log\InvalidArgumentException;
class Logger implements LoggerInterface
{
    const DEBUG = 100;
    const INFO = 200;
    const NOTICE = 250;
    const WARNING = 300;
    const ERROR = 400;
    const CRITICAL = 500;
    const ALERT = 550;
    const EMERGENCY = 600;
    const API = 1;
    protected static $levels = array(100 => 'DEBUG', 200 => 'INFO', 250 => 'NOTICE', 300 => 'WARNING', 400 => 'ERROR', 500 => 'CRITICAL', 550 => 'ALERT', 600 => 'EMERGENCY');
    protected static $timezone;
    protected $name;
    protected $handlers;
    protected $processors;
    public function __construct($name, array $handlers = array(), array $processors = array())
    {
        $this->name = $name;
        $this->handlers = $handlers;
        $this->processors = $processors;
    }
    public function getName()
    {
        return $this->name;
    }
    public function pushHandler(HandlerInterface $handler)
    {
        array_unshift($this->handlers, $handler);
    }
    public function popHandler()
    {
        if (!$this->handlers) {
            throw new \LogicException('You tried to pop from an empty handler stack.');
        }
        return array_shift($this->handlers);
    }
    public function getHandlers()
    {
        return $this->handlers;
    }
    public function pushProcessor($callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Processors must be valid callables (callback or object with an __invoke method), ' . var_export($callback, true) . ' given');
        }
        array_unshift($this->processors, $callback);
    }
    public function popProcessor()
    {
        if (!$this->processors) {
            throw new \LogicException('You tried to pop from an empty processor stack.');
        }
        return array_shift($this->processors);
    }
    public function getProcessors()
    {
        return $this->processors;
    }
    public function addRecord($level, $message, array $context = array())
    {
        if (!$this->handlers) {
            $this->pushHandler(new StreamHandler('php://stderr', static::DEBUG));
        }
        if (!static::$timezone) {
            static::$timezone = new \DateTimeZone(date_default_timezone_get() ?: 'UTC');
        }
        $record = array('message' => (string) $message, 'context' => $context, 'level' => $level, 'level_name' => static::getLevelName($level), 'channel' => $this->name, 'datetime' => \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)), static::$timezone)->setTimezone(static::$timezone), 'extra' => array());
        $handlerKey = null;
        foreach ($this->handlers as $key => $handler) {
            if ($handler->isHandling($record)) {
                $handlerKey = $key;
                break;
            }
        }
        if (null === $handlerKey) {
            return false;
        }
        foreach ($this->processors as $processor) {
            $record = call_user_func($processor, $record);
        }
        while (isset($this->handlers[$handlerKey]) && false === $this->handlers[$handlerKey]->handle($record)) {
            $handlerKey++;
        }
        return true;
    }
    public function addDebug($message, array $context = array())
    {
        return $this->addRecord(static::DEBUG, $message, $context);
    }
    public function addInfo($message, array $context = array())
    {
        return $this->addRecord(static::INFO, $message, $context);
    }
    public function addNotice($message, array $context = array())
    {
        return $this->addRecord(static::NOTICE, $message, $context);
    }
    public function addWarning($message, array $context = array())
    {
        return $this->addRecord(static::WARNING, $message, $context);
    }
    public function addError($message, array $context = array())
    {
        return $this->addRecord(static::ERROR, $message, $context);
    }
    public function addCritical($message, array $context = array())
    {
        return $this->addRecord(static::CRITICAL, $message, $context);
    }
    public function addAlert($message, array $context = array())
    {
        return $this->addRecord(static::ALERT, $message, $context);
    }
    public function addEmergency($message, array $context = array())
    {
        return $this->addRecord(static::EMERGENCY, $message, $context);
    }
    public static function getLevels()
    {
        return array_flip(static::$levels);
    }
    public static function getLevelName($level)
    {
        if (!isset(static::$levels[$level])) {
            throw new InvalidArgumentException('Level "' . $level . '" is not defined, use one of: ' . implode(', ', array_keys(static::$levels)));
        }
        return static::$levels[$level];
    }
    public static function toMonologLevel($level)
    {
        if (is_string($level) && defined(__CLASS__ . '::' . strtoupper($level))) {
            return constant(__CLASS__ . '::' . strtoupper($level));
        }
        return $level;
    }
    public function isHandling($level)
    {
        $record = array('level' => $level);
        foreach ($this->handlers as $handler) {
            if ($handler->isHandling($record)) {
                return true;
            }
        }
        return false;
    }
    public function log($level, $message, array $context = array())
    {
        if (is_string($level) && defined(__CLASS__ . '::' . strtoupper($level))) {
            $level = constant(__CLASS__ . '::' . strtoupper($level));
        }
        return $this->addRecord($level, $message, $context);
    }
    public function debug($message, array $context = array())
    {
        return $this->addRecord(static::DEBUG, $message, $context);
    }
    public function info($message, array $context = array())
    {
        return $this->addRecord(static::INFO, $message, $context);
    }
    public function notice($message, array $context = array())
    {
        return $this->addRecord(static::NOTICE, $message, $context);
    }
    public function warn($message, array $context = array())
    {
        return $this->addRecord(static::WARNING, $message, $context);
    }
    public function warning($message, array $context = array())
    {
        return $this->addRecord(static::WARNING, $message, $context);
    }
    public function err($message, array $context = array())
    {
        return $this->addRecord(static::ERROR, $message, $context);
    }
    public function error($message, array $context = array())
    {
        return $this->addRecord(static::ERROR, $message, $context);
    }
    public function crit($message, array $context = array())
    {
        return $this->addRecord(static::CRITICAL, $message, $context);
    }
    public function critical($message, array $context = array())
    {
        return $this->addRecord(static::CRITICAL, $message, $context);
    }
    public function alert($message, array $context = array())
    {
        return $this->addRecord(static::ALERT, $message, $context);
    }
    public function emerg($message, array $context = array())
    {
        return $this->addRecord(static::EMERGENCY, $message, $context);
    }
    public function emergency($message, array $context = array())
    {
        return $this->addRecord(static::EMERGENCY, $message, $context);
    }
}
namespace Psr\Log;

interface LoggerInterface
{
    public function emergency($message, array $context = array());
    public function alert($message, array $context = array());
    public function critical($message, array $context = array());
    public function error($message, array $context = array());
    public function warning($message, array $context = array());
    public function notice($message, array $context = array());
    public function info($message, array $context = array());
    public function debug($message, array $context = array());
    public function log($level, $message, array $context = array());
}
namespace Monolog\Handler;

use Monolog\Logger;
use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LineFormatter;
abstract class AbstractHandler implements HandlerInterface
{
    protected $level = Logger::DEBUG;
    protected $bubble = true;
    protected $formatter;
    protected $processors = array();
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        $this->setLevel($level);
        $this->bubble = $bubble;
    }
    public function isHandling(array $record)
    {
        return $record['level'] >= $this->level;
    }
    public function handleBatch(array $records)
    {
        foreach ($records as $record) {
            $this->handle($record);
        }
    }
    public function close()
    {
        
    }
    public function pushProcessor($callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Processors must be valid callables (callback or object with an __invoke method), ' . var_export($callback, true) . ' given');
        }
        array_unshift($this->processors, $callback);
        return $this;
    }
    public function popProcessor()
    {
        if (!$this->processors) {
            throw new \LogicException('You tried to pop from an empty processor stack.');
        }
        return array_shift($this->processors);
    }
    public function setFormatter(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
        return $this;
    }
    public function getFormatter()
    {
        if (!$this->formatter) {
            $this->formatter = $this->getDefaultFormatter();
        }
        return $this->formatter;
    }
    public function setLevel($level)
    {
        $this->level = Logger::toMonologLevel($level);
        return $this;
    }
    public function getLevel()
    {
        return $this->level;
    }
    public function setBubble($bubble)
    {
        $this->bubble = $bubble;
        return $this;
    }
    public function getBubble()
    {
        return $this->bubble;
    }
    public function __destruct()
    {
        try {
            $this->close();
        } catch (\Exception $e) {
            
        }
    }
    protected function getDefaultFormatter()
    {
        return new LineFormatter();
    }
}
namespace Monolog\Handler;

abstract class AbstractProcessingHandler extends AbstractHandler
{
    public function handle(array $record)
    {
        if (!$this->isHandling($record)) {
            return false;
        }
        $record = $this->processRecord($record);
        $record['formatted'] = $this->getFormatter()->format($record);
        $this->write($record);
        return false === $this->bubble;
    }
    protected abstract function write(array $record);
    protected function processRecord(array $record)
    {
        if ($this->processors) {
            foreach ($this->processors as $processor) {
                $record = call_user_func($processor, $record);
            }
        }
        return $record;
    }
}
namespace Monolog\Handler;

use Monolog\Logger;
class StreamHandler extends AbstractProcessingHandler
{
    protected $stream;
    protected $url;
    private $errorMessage;
    protected $filePermission;
    protected $useLocking;
    public function __construct($stream, $level = Logger::DEBUG, $bubble = true, $filePermission = null, $useLocking = false)
    {
        parent::__construct($level, $bubble);
        if (is_resource($stream)) {
            $this->stream = $stream;
        } elseif (is_string($stream)) {
            $this->url = $stream;
        } else {
            throw new \InvalidArgumentException('A stream must either be a resource or a string.');
        }
        $this->filePermission = $filePermission;
        $this->useLocking = $useLocking;
    }
    public function close()
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }
        $this->stream = null;
    }
    protected function write(array $record)
    {
        if (!is_resource($this->stream)) {
            if (!$this->url) {
                throw new \LogicException('Missing stream url, the stream can not be opened. This may be caused by a premature call to close().');
            }
            $this->errorMessage = null;
            set_error_handler(array($this, 'customErrorHandler'));
            $this->stream = fopen($this->url, 'a');
            if ($this->filePermission !== null) {
                @chmod($this->url, $this->filePermission);
            }
            restore_error_handler();
            if (!is_resource($this->stream)) {
                $this->stream = null;
                throw new \UnexpectedValueException(sprintf('The stream or file "%s" could not be opened: ' . $this->errorMessage, $this->url));
            }
        }
        if ($this->useLocking) {
            flock($this->stream, LOCK_EX);
        }
        fwrite($this->stream, (string) $record['formatted']);
        if ($this->useLocking) {
            flock($this->stream, LOCK_UN);
        }
    }
    private function customErrorHandler($code, $msg)
    {
        $this->errorMessage = preg_replace('{^fopen\\(.*?\\): }', '', $msg);
    }
}
namespace Monolog\Handler;

use Monolog\Logger;
class RotatingFileHandler extends StreamHandler
{
    protected $filename;
    protected $maxFiles;
    protected $mustRotate;
    protected $nextRotation;
    protected $filenameFormat;
    protected $dateFormat;
    public function __construct($filename, $maxFiles = 0, $level = Logger::DEBUG, $bubble = true, $filePermission = null, $useLocking = false)
    {
        $this->filename = $filename;
        $this->maxFiles = (int) $maxFiles;
        $this->nextRotation = new \DateTime('tomorrow');
        $this->filenameFormat = '{filename}-{date}';
        $this->dateFormat = 'Y-m-d';
        parent::__construct($this->getTimedFilename(), $level, $bubble, $filePermission, $useLocking);
    }
    public function close()
    {
        parent::close();
        if (true === $this->mustRotate) {
            $this->rotate();
        }
    }
    public function setFilenameFormat($filenameFormat, $dateFormat)
    {
        $this->filenameFormat = $filenameFormat;
        $this->dateFormat = $dateFormat;
        $this->url = $this->getTimedFilename();
        $this->close();
    }
    protected function write(array $record)
    {
        if (null === $this->mustRotate) {
            $this->mustRotate = !file_exists($this->url);
        }
        if ($this->nextRotation < $record['datetime']) {
            $this->mustRotate = true;
            $this->close();
        }
        parent::write($record);
    }
    protected function rotate()
    {
        $this->url = $this->getTimedFilename();
        $this->nextRotation = new \DateTime('tomorrow');
        if (0 === $this->maxFiles) {
            return;
        }
        $logFiles = glob($this->getGlobPattern());
        if ($this->maxFiles >= count($logFiles)) {
            return;
        }
        usort($logFiles, function ($a, $b) {
            return strcmp($b, $a);
        });
        foreach (array_slice($logFiles, $this->maxFiles) as $file) {
            if (is_writable($file)) {
                unlink($file);
            }
        }
    }
    protected function getTimedFilename()
    {
        $fileInfo = pathinfo($this->filename);
        $timedFilename = str_replace(array('{filename}', '{date}'), array($fileInfo['filename'], date($this->dateFormat)), $fileInfo['dirname'] . '/' . $this->filenameFormat);
        if (!empty($fileInfo['extension'])) {
            $timedFilename .= '.' . $fileInfo['extension'];
        }
        return $timedFilename;
    }
    protected function getGlobPattern()
    {
        $fileInfo = pathinfo($this->filename);
        $glob = str_replace(array('{filename}', '{date}'), array($fileInfo['filename'], '*'), $fileInfo['dirname'] . '/' . $this->filenameFormat);
        if (!empty($fileInfo['extension'])) {
            $glob .= '.' . $fileInfo['extension'];
        }
        return $glob;
    }
}
namespace Monolog\Handler;

use Monolog\Formatter\FormatterInterface;
interface HandlerInterface
{
    public function isHandling(array $record);
    public function handle(array $record);
    public function handleBatch(array $records);
    public function pushProcessor($callback);
    public function popProcessor();
    public function setFormatter(FormatterInterface $formatter);
    public function getFormatter();
}
namespace Monolog\Formatter;

interface FormatterInterface
{
    public function format(array $record);
    public function formatBatch(array $records);
}
namespace Monolog\Formatter;

use Exception;
class NormalizerFormatter implements FormatterInterface
{
    const SIMPLE_DATE = 'Y-m-d H:i:s';
    protected $dateFormat;
    public function __construct($dateFormat = null)
    {
        $this->dateFormat = $dateFormat ?: static::SIMPLE_DATE;
        if (!function_exists('json_encode')) {
            throw new \RuntimeException('PHP\'s json extension is required to use Monolog\'s NormalizerFormatter');
        }
    }
    public function format(array $record)
    {
        return $this->normalize($record);
    }
    public function formatBatch(array $records)
    {
        foreach ($records as $key => $record) {
            $records[$key] = $this->format($record);
        }
        return $records;
    }
    protected function normalize($data)
    {
        if (null === $data || is_scalar($data)) {
            return $data;
        }
        if (is_array($data) || $data instanceof \Traversable) {
            $normalized = array();
            $count = 1;
            foreach ($data as $key => $value) {
                if ($count++ >= 1000) {
                    $normalized['...'] = 'Over 1000 items, aborting normalization';
                    break;
                }
                $normalized[$key] = $this->normalize($value);
            }
            return $normalized;
        }
        if ($data instanceof \DateTime) {
            return $data->format($this->dateFormat);
        }
        if (is_object($data)) {
            if ($data instanceof Exception) {
                return $this->normalizeException($data);
            }
            return sprintf('[object] (%s: %s)', get_class($data), $this->toJson($data, true));
        }
        if (is_resource($data)) {
            return '[resource]';
        }
        return '[unknown(' . gettype($data) . ')]';
    }
    protected function normalizeException(Exception $e)
    {
        $data = array('class' => get_class($e), 'message' => $e->getMessage(), 'file' => $e->getFile() . ':' . $e->getLine());
        $trace = $e->getTrace();
        foreach ($trace as $frame) {
            if (isset($frame['file'])) {
                $data['trace'][] = $frame['file'] . ':' . $frame['line'];
            } else {
                $data['trace'][] = json_encode($frame);
            }
        }
        if ($previous = $e->getPrevious()) {
            $data['previous'] = $this->normalizeException($previous);
        }
        return $data;
    }
    protected function toJson($data, $ignoreErrors = false)
    {
        if ($ignoreErrors) {
            if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
                return @json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
            return @json_encode($data);
        }
        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        return json_encode($data);
    }
}
namespace Monolog\Formatter;

use Exception;
class LineFormatter extends NormalizerFormatter
{
    const SIMPLE_FORMAT = '[%datetime%] %channel%.%level_name%: %message% %context% %extra%
';
    protected $format;
    protected $allowInlineLineBreaks;
    protected $ignoreEmptyContextAndExtra;
    public function __construct($format = null, $dateFormat = null, $allowInlineLineBreaks = false, $ignoreEmptyContextAndExtra = false)
    {
        $this->format = $format ?: static::SIMPLE_FORMAT;
        $this->allowInlineLineBreaks = $allowInlineLineBreaks;
        $this->ignoreEmptyContextAndExtra = $ignoreEmptyContextAndExtra;
        parent::__construct($dateFormat);
    }
    public function format(array $record)
    {
        $vars = parent::format($record);
        $output = $this->format;
        foreach ($vars['extra'] as $var => $val) {
            if (false !== strpos($output, '%extra.' . $var . '%')) {
                $output = str_replace('%extra.' . $var . '%', $this->replaceNewlines($this->convertToString($val)), $output);
                unset($vars['extra'][$var]);
            }
        }
        if ($this->ignoreEmptyContextAndExtra) {
            if (empty($vars['context'])) {
                unset($vars['context']);
                $output = str_replace('%context%', '', $output);
            }
            if (empty($vars['extra'])) {
                unset($vars['extra']);
                $output = str_replace('%extra%', '', $output);
            }
        }
        foreach ($vars as $var => $val) {
            if (false !== strpos($output, '%' . $var . '%')) {
                $output = str_replace('%' . $var . '%', $this->replaceNewlines($this->convertToString($val)), $output);
            }
        }
        return $output;
    }
    public function formatBatch(array $records)
    {
        $message = '';
        foreach ($records as $record) {
            $message .= $this->format($record);
        }
        return $message;
    }
    protected function normalizeException(Exception $e)
    {
        $previousText = '';
        if ($previous = $e->getPrevious()) {
            do {
                $previousText .= ', ' . get_class($previous) . ': ' . $previous->getMessage() . ' at ' . $previous->getFile() . ':' . $previous->getLine();
            } while ($previous = $previous->getPrevious());
        }
        return '[object] (' . get_class($e) . ': ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine() . $previousText . ')';
    }
    protected function convertToString($data)
    {
        if (null === $data || is_bool($data)) {
            return var_export($data, true);
        }
        if (is_scalar($data)) {
            return (string) $data;
        }
        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            return $this->toJson($data, true);
        }
        return str_replace('\\/', '/', @json_encode($data));
    }
    protected function replaceNewlines($str)
    {
        if ($this->allowInlineLineBreaks) {
            return $str;
        }
        return strtr($str, array('
' => ' ', '' => ' ', '
' => ' '));
    }
}
namespace Illuminate\Support\Facades;

class App extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'app';
    }
}
namespace Illuminate\Exception;

use Exception;
interface ExceptionDisplayerInterface
{
    public function display(Exception $exception);
}
namespace Illuminate\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
class PlainDisplayer implements ExceptionDisplayerInterface
{
    public function display(Exception $exception)
    {
        $status = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;
        $headers = $exception instanceof HttpExceptionInterface ? $exception->getHeaders() : array();
        return new Response(file_get_contents('/home/vagrant/html/streams/vendor/laravel/framework/src/Illuminate/Exception' . '/resources/plain.html'), $status, $headers);
    }
}
namespace Illuminate\Exception;

use Exception;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
class SymfonyDisplayer implements ExceptionDisplayerInterface
{
    protected $symfony;
    protected $returnJson;
    public function __construct(ExceptionHandler $symfony, $returnJson = false)
    {
        $this->symfony = $symfony;
        $this->returnJson = $returnJson;
    }
    public function display(Exception $exception)
    {
        if ($this->returnJson) {
            return new JsonResponse(array('error' => $exception->getMessage(), 'file' => $exception->getFile(), 'line' => $exception->getLine()), 500);
        }
        return $this->symfony->createResponse($exception);
    }
}
namespace Illuminate\Exception;

use Exception;
use Whoops\Run;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
class WhoopsDisplayer implements ExceptionDisplayerInterface
{
    protected $whoops;
    protected $runningInConsole;
    public function __construct(Run $whoops, $runningInConsole)
    {
        $this->whoops = $whoops;
        $this->runningInConsole = $runningInConsole;
    }
    public function display(Exception $exception)
    {
        $status = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;
        $headers = $exception instanceof HttpExceptionInterface ? $exception->getHeaders() : array();
        return new Response($this->whoops->handleException($exception), $status, $headers);
    }
}
namespace Illuminate\Exception;

use Closure;
use Exception;
use ErrorException;
use ReflectionFunction;
use Illuminate\Contracts\Support\ResponsePreparer;
use Illuminate\Contracts\Exception\Handler as HandlerContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Debug\Exception\FatalErrorException as FatalError;
class Handler implements HandlerContract
{
    protected $responsePreparer;
    protected $plainDisplayer;
    protected $debugDisplayer;
    protected $debug;
    protected $handlers = array();
    protected $handled = array();
    public function __construct(ResponsePreparer $responsePreparer, ExceptionDisplayerInterface $plainDisplayer, ExceptionDisplayerInterface $debugDisplayer, $debug = true)
    {
        $this->debug = $debug;
        $this->plainDisplayer = $plainDisplayer;
        $this->debugDisplayer = $debugDisplayer;
        $this->responsePreparer = $responsePreparer;
    }
    public function register($environment)
    {
        $this->registerErrorHandler();
        $this->registerExceptionHandler();
        if ($environment != 'testing') {
            $this->registerShutdownHandler();
        }
    }
    protected function registerErrorHandler()
    {
        set_error_handler(array($this, 'handleError'));
    }
    protected function registerExceptionHandler()
    {
        set_exception_handler(array($this, 'handleUncaughtException'));
    }
    protected function registerShutdownHandler()
    {
        register_shutdown_function(array($this, 'handleShutdown'));
    }
    public function handleError($level, $message, $file = '', $line = 0, $context = array())
    {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }
    public function handleException(Exception $exception)
    {
        $response = $this->callCustomHandlers($exception);
        if (!is_null($response)) {
            return $this->prepareResponse($response);
        }
        return $this->displayException($exception);
    }
    public function handleUncaughtException($exception)
    {
        $this->handleException($exception)->send();
    }
    public function handleShutdown()
    {
        $error = error_get_last();
        if (!is_null($error)) {
            extract($error);
            if (!$this->isFatal($type)) {
                return;
            }
            $this->handleException(new FatalError($message, $type, 0, $file, $line))->send();
        }
    }
    protected function isFatal($type)
    {
        return in_array($type, array(E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE));
    }
    public function handleConsole($exception)
    {
        return $this->callCustomHandlers($exception, true);
    }
    protected function callCustomHandlers($exception, $fromConsole = false)
    {
        foreach ($this->handlers as $handler) {
            if (!$this->handlesException($handler, $exception)) {
                continue;
            } elseif ($exception instanceof HttpExceptionInterface) {
                $code = $exception->getStatusCode();
            } else {
                $code = 500;
            }
            try {
                $response = $handler($exception, $code, $fromConsole);
            } catch (\Exception $e) {
                $response = $this->formatException($e);
            }
            if (isset($response) && !is_null($response)) {
                return $response;
            }
        }
    }
    protected function displayException($exception)
    {
        $displayer = $this->debug ? $this->debugDisplayer : $this->plainDisplayer;
        return $displayer->display($exception);
    }
    protected function handlesException(Closure $handler, $exception)
    {
        $reflection = new ReflectionFunction($handler);
        return $reflection->getNumberOfParameters() == 0 || $this->hints($reflection, $exception);
    }
    protected function hints(ReflectionFunction $reflection, $exception)
    {
        $parameters = $reflection->getParameters();
        $expected = $parameters[0];
        return !$expected->getClass() || $expected->getClass()->isInstance($exception);
    }
    protected function formatException(\Exception $e)
    {
        if ($this->debug) {
            $location = $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
            return 'Error in exception handler: ' . $location;
        }
        return 'Error in exception handler.';
    }
    public function error(Closure $callback)
    {
        array_unshift($this->handlers, $callback);
    }
    public function pushError(Closure $callback)
    {
        $this->handlers[] = $callback;
    }
    public function missing(Closure $callback)
    {
        $this->error(function (NotFoundHttpException $e) use($callback) {
            return call_user_func($callback, $e);
        });
    }
    public function fatal(Closure $callback)
    {
        $this->error(function (FatalError $e) use($callback) {
            return call_user_func($callback, $e);
        });
    }
    protected function prepareResponse($response)
    {
        return $this->responsePreparer->prepareResponse($response);
    }
    public function runningInConsole()
    {
        return php_sapi_name() == 'cli';
    }
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }
}
namespace Illuminate\Support\Facades;

class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'router';
    }
}
namespace Illuminate\View\Engines;

use Closure;
class EngineResolver
{
    protected $resolvers = array();
    protected $resolved = array();
    public function register($engine, Closure $resolver)
    {
        $this->resolvers[$engine] = $resolver;
    }
    public function resolve($engine)
    {
        if (isset($this->resolved[$engine])) {
            return $this->resolved[$engine];
        }
        if (isset($this->resolvers[$engine])) {
            return $this->resolved[$engine] = call_user_func($this->resolvers[$engine]);
        }
        throw new \InvalidArgumentException("Engine {$engine} not found.");
    }
}
namespace Illuminate\View;

interface ViewFinderInterface
{
    const HINT_PATH_DELIMITER = '::';
    public function find($view);
    public function addLocation($location);
    public function addNamespace($namespace, $hints);
    public function prependNamespace($namespace, $hints);
    public function addExtension($extension);
}
namespace Illuminate\View;

use Illuminate\Filesystem\Filesystem;
class FileViewFinder implements ViewFinderInterface
{
    protected $files;
    protected $paths;
    protected $views = array();
    protected $hints = array();
    protected $extensions = array('blade.php', 'php');
    public function __construct(Filesystem $files, array $paths, array $extensions = null)
    {
        $this->files = $files;
        $this->paths = $paths;
        if (isset($extensions)) {
            $this->extensions = $extensions;
        }
    }
    public function find($name)
    {
        if (isset($this->views[$name])) {
            return $this->views[$name];
        }
        if ($this->hasHintInformation($name = trim($name))) {
            return $this->views[$name] = $this->findNamedPathView($name);
        }
        return $this->views[$name] = $this->findInPaths($name, $this->paths);
    }
    protected function findNamedPathView($name)
    {
        list($namespace, $view) = $this->getNamespaceSegments($name);
        return $this->findInPaths($view, $this->hints[$namespace]);
    }
    protected function getNamespaceSegments($name)
    {
        $segments = explode(static::HINT_PATH_DELIMITER, $name);
        if (count($segments) != 2) {
            throw new \InvalidArgumentException("View [{$name}] has an invalid name.");
        }
        if (!isset($this->hints[$segments[0]])) {
            throw new \InvalidArgumentException("No hint path defined for [{$segments[0]}].");
        }
        return $segments;
    }
    protected function findInPaths($name, $paths)
    {
        foreach ((array) $paths as $path) {
            foreach ($this->getPossibleViewFiles($name) as $file) {
                if ($this->files->exists($viewPath = $path . '/' . $file)) {
                    return $viewPath;
                }
            }
        }
        throw new \InvalidArgumentException("View [{$name}] not found.");
    }
    protected function getPossibleViewFiles($name)
    {
        return array_map(function ($extension) use($name) {
            return str_replace('.', '/', $name) . '.' . $extension;
        }, $this->extensions);
    }
    public function addLocation($location)
    {
        $this->paths[] = $location;
    }
    public function addNamespace($namespace, $hints)
    {
        $hints = (array) $hints;
        if (isset($this->hints[$namespace])) {
            $hints = array_merge($this->hints[$namespace], $hints);
        }
        $this->hints[$namespace] = $hints;
    }
    public function prependNamespace($namespace, $hints)
    {
        $hints = (array) $hints;
        if (isset($this->hints[$namespace])) {
            $hints = array_merge($hints, $this->hints[$namespace]);
        }
        $this->hints[$namespace] = $hints;
    }
    public function addExtension($extension)
    {
        if (($index = array_search($extension, $this->extensions)) !== false) {
            unset($this->extensions[$index]);
        }
        array_unshift($this->extensions, $extension);
    }
    public function hasHintInformation($name)
    {
        return strpos($name, static::HINT_PATH_DELIMITER) > 0;
    }
    public function getFilesystem()
    {
        return $this->files;
    }
    public function getPaths()
    {
        return $this->paths;
    }
    public function getHints()
    {
        return $this->hints;
    }
    public function getExtensions()
    {
        return $this->extensions;
    }
}
namespace Illuminate\View;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory as FactoryContract;
class Factory implements FactoryContract
{
    protected $engines;
    protected $finder;
    protected $events;
    protected $container;
    protected $shared = array();
    protected $aliases = array();
    protected $names = array();
    protected $extensions = array('blade.php' => 'blade', 'php' => 'php');
    protected $composers = array();
    protected $sections = array();
    protected $sectionStack = array();
    protected $renderCount = 0;
    public function __construct(EngineResolver $engines, ViewFinderInterface $finder, Dispatcher $events)
    {
        $this->finder = $finder;
        $this->events = $events;
        $this->engines = $engines;
        $this->share('__env', $this);
    }
    protected function normalizeName($name)
    {
        $delimiter = ViewFinderInterface::HINT_PATH_DELIMITER;
        if (strpos($name, $delimiter) === false) {
            return str_replace('/', '.', $name);
        }
        list($namespace, $name) = explode($delimiter, $name);
        return $namespace . $delimiter . str_replace('/', '.', $name);
    }
    public function make($view, $data = array(), $mergeData = array())
    {
        if (isset($this->aliases[$view])) {
            $view = $this->aliases[$view];
        }
        $view = $this->normalizeName($view);
        $path = $this->finder->find($view);
        $data = array_merge($mergeData, $this->parseData($data));
        $this->callCreator($view = new View($this, $this->getEngineFromPath($path), $view, $path, $data));
        return $view;
    }
    protected function parseData($data)
    {
        return $data instanceof Arrayable ? $data->toArray() : $data;
    }
    public function of($view, $data = array())
    {
        return $this->make($this->names[$view], $data);
    }
    public function name($view, $name)
    {
        $this->names[$name] = $view;
    }
    public function alias($view, $alias)
    {
        $this->aliases[$alias] = $view;
    }
    public function exists($view)
    {
        try {
            $this->finder->find($view);
        } catch (\InvalidArgumentException $e) {
            return false;
        }
        return true;
    }
    public function renderEach($view, $data, $iterator, $empty = 'raw|')
    {
        $result = '';
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $data = array('key' => $key, $iterator => $value);
                $result .= $this->make($view, $data)->render();
            }
        } else {
            if (starts_with($empty, 'raw|')) {
                $result = substr($empty, 4);
            } else {
                $result = $this->make($empty)->render();
            }
        }
        return $result;
    }
    public function getEngineFromPath($path)
    {
        if (!($extension = $this->getExtension($path))) {
            throw new \InvalidArgumentException("Unrecognized extension in file: {$path}");
        }
        $engine = $this->extensions[$extension];
        return $this->engines->resolve($engine);
    }
    protected function getExtension($path)
    {
        $extensions = array_keys($this->extensions);
        return array_first($extensions, function ($key, $value) use($path) {
            return ends_with($path, $value);
        });
    }
    public function share($key, $value = null)
    {
        if (!is_array($key)) {
            return $this->shared[$key] = $value;
        }
        foreach ($key as $innerKey => $innerValue) {
            $this->share($innerKey, $innerValue);
        }
    }
    public function creator($views, $callback)
    {
        $creators = array();
        foreach ((array) $views as $view) {
            $creators[] = $this->addViewEvent($view, $callback, 'creating: ');
        }
        return $creators;
    }
    public function composers(array $composers)
    {
        $registered = array();
        foreach ($composers as $callback => $views) {
            $registered += $this->composer($views, $callback);
        }
        return $registered;
    }
    public function composer($views, $callback, $priority = null)
    {
        $composers = array();
        foreach ((array) $views as $view) {
            $composers[] = $this->addViewEvent($view, $callback, 'composing: ', $priority);
        }
        return $composers;
    }
    protected function addViewEvent($view, $callback, $prefix = 'composing: ', $priority = null)
    {
        $view = $this->normalizeName($view);
        if ($callback instanceof Closure) {
            $this->addEventListener($prefix . $view, $callback, $priority);
            return $callback;
        } elseif (is_string($callback)) {
            return $this->addClassEvent($view, $callback, $prefix, $priority);
        }
    }
    protected function addClassEvent($view, $class, $prefix, $priority = null)
    {
        $name = $prefix . $view;
        $callback = $this->buildClassEventCallback($class, $prefix);
        $this->addEventListener($name, $callback, $priority);
        return $callback;
    }
    protected function addEventListener($name, $callback, $priority = null)
    {
        if (is_null($priority)) {
            $this->events->listen($name, $callback);
        } else {
            $this->events->listen($name, $callback, $priority);
        }
    }
    protected function buildClassEventCallback($class, $prefix)
    {
        $container = $this->container;
        list($class, $method) = $this->parseClassEvent($class, $prefix);
        return function () use($class, $method, $container) {
            $callable = array($container->make($class), $method);
            return call_user_func_array($callable, func_get_args());
        };
    }
    protected function parseClassEvent($class, $prefix)
    {
        if (str_contains($class, '@')) {
            return explode('@', $class);
        }
        $method = str_contains($prefix, 'composing') ? 'compose' : 'create';
        return array($class, $method);
    }
    public function callComposer(View $view)
    {
        $this->events->fire('composing: ' . $view->getName(), array($view));
    }
    public function callCreator(View $view)
    {
        $this->events->fire('creating: ' . $view->getName(), array($view));
    }
    public function startSection($section, $content = '')
    {
        if ($content === '') {
            if (ob_start()) {
                $this->sectionStack[] = $section;
            }
        } else {
            $this->extendSection($section, $content);
        }
    }
    public function inject($section, $content)
    {
        return $this->startSection($section, $content);
    }
    public function yieldSection()
    {
        return $this->yieldContent($this->stopSection());
    }
    public function stopSection($overwrite = false)
    {
        $last = array_pop($this->sectionStack);
        if ($overwrite) {
            $this->sections[$last] = ob_get_clean();
        } else {
            $this->extendSection($last, ob_get_clean());
        }
        return $last;
    }
    public function appendSection()
    {
        $last = array_pop($this->sectionStack);
        if (isset($this->sections[$last])) {
            $this->sections[$last] .= ob_get_clean();
        } else {
            $this->sections[$last] = ob_get_clean();
        }
        return $last;
    }
    protected function extendSection($section, $content)
    {
        if (isset($this->sections[$section])) {
            $content = str_replace('@parent', $content, $this->sections[$section]);
        }
        $this->sections[$section] = $content;
    }
    public function yieldContent($section, $default = '')
    {
        $sectionContent = $default;
        if (isset($this->sections[$section])) {
            $sectionContent = $this->sections[$section];
        }
        return str_replace('@parent', '', $sectionContent);
    }
    public function flushSections()
    {
        $this->sections = array();
        $this->sectionStack = array();
    }
    public function flushSectionsIfDoneRendering()
    {
        if ($this->doneRendering()) {
            $this->flushSections();
        }
    }
    public function incrementRender()
    {
        $this->renderCount++;
    }
    public function decrementRender()
    {
        $this->renderCount--;
    }
    public function doneRendering()
    {
        return $this->renderCount == 0;
    }
    public function addLocation($location)
    {
        $this->finder->addLocation($location);
    }
    public function addNamespace($namespace, $hints)
    {
        $this->finder->addNamespace($namespace, $hints);
    }
    public function prependNamespace($namespace, $hints)
    {
        $this->finder->prependNamespace($namespace, $hints);
    }
    public function addExtension($extension, $engine, $resolver = null)
    {
        $this->finder->addExtension($extension);
        if (isset($resolver)) {
            $this->engines->register($engine, $resolver);
        }
        unset($this->extensions[$extension]);
        $this->extensions = array_merge(array($extension => $engine), $this->extensions);
    }
    public function getExtensions()
    {
        return $this->extensions;
    }
    public function getEngineResolver()
    {
        return $this->engines;
    }
    public function getFinder()
    {
        return $this->finder;
    }
    public function setFinder(ViewFinderInterface $finder)
    {
        $this->finder = $finder;
    }
    public function getDispatcher()
    {
        return $this->events;
    }
    public function setDispatcher(Dispatcher $events)
    {
        $this->events = $events;
    }
    public function getContainer()
    {
        return $this->container;
    }
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
    public function shared($key, $default = null)
    {
        return array_get($this->shared, $key, $default);
    }
    public function getShared()
    {
        return $this->shared;
    }
    public function getSections()
    {
        return $this->sections;
    }
    public function getNames()
    {
        return $this->names;
    }
}
namespace Illuminate\Support;

use Countable;
class ViewErrorBag implements Countable
{
    protected $bags = array();
    public function hasBag($key = 'default')
    {
        return isset($this->bags[$key]);
    }
    public function getBag($key)
    {
        return array_get($this->bags, $key, new MessageBag());
    }
    public function put($key, MessageBag $bag)
    {
        $this->bags[$key] = $bag;
        return $this;
    }
    public function count()
    {
        return $this->default->count();
    }
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->default, $method), $parameters);
    }
    public function __get($key)
    {
        return array_get($this->bags, $key, new MessageBag());
    }
    public function __set($key, $value)
    {
        array_set($this->bags, $key, $value);
    }
}
namespace Illuminate\Support;

use Countable;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\MessageProvider;
use Illuminate\Contracts\Support\MessageBag as MessageBagContract;
class MessageBag implements Arrayable, Countable, Jsonable, JsonSerializable, MessageBagContract, MessageProvider
{
    protected $messages = array();
    protected $format = ':message';
    public function __construct(array $messages = array())
    {
        foreach ($messages as $key => $value) {
            $this->messages[$key] = (array) $value;
        }
    }
    public function keys()
    {
        return array_keys($this->messages);
    }
    public function add($key, $message)
    {
        if ($this->isUnique($key, $message)) {
            $this->messages[$key][] = $message;
        }
        return $this;
    }
    public function merge($messages)
    {
        if ($messages instanceof MessageProvider) {
            $messages = $messages->getMessageBag()->getMessages();
        }
        $this->messages = array_merge_recursive($this->messages, $messages);
        return $this;
    }
    protected function isUnique($key, $message)
    {
        $messages = (array) $this->messages;
        return !isset($messages[$key]) || !in_array($message, $messages[$key]);
    }
    public function has($key = null)
    {
        return $this->first($key) !== '';
    }
    public function first($key = null, $format = null)
    {
        $messages = is_null($key) ? $this->all($format) : $this->get($key, $format);
        return count($messages) > 0 ? $messages[0] : '';
    }
    public function get($key, $format = null)
    {
        $format = $this->checkFormat($format);
        if (array_key_exists($key, $this->messages)) {
            return $this->transform($this->messages[$key], $format, $key);
        }
        return array();
    }
    public function all($format = null)
    {
        $format = $this->checkFormat($format);
        $all = array();
        foreach ($this->messages as $key => $messages) {
            $all = array_merge($all, $this->transform($messages, $format, $key));
        }
        return $all;
    }
    protected function transform($messages, $format, $messageKey)
    {
        $messages = (array) $messages;
        foreach ($messages as &$message) {
            $replace = array(':message', ':key');
            $message = str_replace($replace, array($message, $messageKey), $format);
        }
        return $messages;
    }
    protected function checkFormat($format)
    {
        return $format === null ? $this->format : $format;
    }
    public function getMessages()
    {
        return $this->messages;
    }
    public function getMessageBag()
    {
        return $this;
    }
    public function getFormat()
    {
        return $this->format;
    }
    public function setFormat($format = ':message')
    {
        $this->format = $format;
        return $this;
    }
    public function isEmpty()
    {
        return !$this->any();
    }
    public function any()
    {
        return $this->count() > 0;
    }
    public function count()
    {
        return count($this->messages, COUNT_RECURSIVE) - count($this->messages);
    }
    public function toArray()
    {
        return $this->getMessages();
    }
    public function jsonSerialize()
    {
        return $this->toArray();
    }
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
    public function __toString()
    {
        return $this->toJson();
    }
}
namespace Illuminate\Support\Facades;

class View extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'view';
    }
}
namespace Illuminate\View;

use Closure;
use ArrayAccess;
use Illuminate\Support\MessageBag;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\View\Engines\EngineInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\MessageProvider;
use Illuminate\Contracts\View\View as ViewContract;
class View implements ArrayAccess, ViewContract
{
    protected $factory;
    protected $engine;
    protected $view;
    protected $data;
    protected $path;
    public function __construct(Factory $factory, EngineInterface $engine, $view, $path, $data = array())
    {
        $this->view = $view;
        $this->path = $path;
        $this->engine = $engine;
        $this->factory = $factory;
        $this->data = $data instanceof Arrayable ? $data->toArray() : (array) $data;
    }
    public function render(Closure $callback = null)
    {
        $contents = $this->renderContents();
        $response = isset($callback) ? $callback($this, $contents) : null;
        $this->factory->flushSectionsIfDoneRendering();
        return $response ?: $contents;
    }
    protected function renderContents()
    {
        $this->factory->incrementRender();
        $this->factory->callComposer($this);
        $contents = $this->getContents();
        $this->factory->decrementRender();
        return $contents;
    }
    public function renderSections()
    {
        $env = $this->factory;
        return $this->render(function ($view) use($env) {
            return $env->getSections();
        });
    }
    protected function getContents()
    {
        return $this->engine->get($this->path, $this->gatherData());
    }
    protected function gatherData()
    {
        $data = array_merge($this->factory->getShared(), $this->data);
        foreach ($data as $key => $value) {
            if ($value instanceof Renderable) {
                $data[$key] = $value->render();
            }
        }
        return $data;
    }
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }
        return $this;
    }
    public function nest($key, $view, array $data = array())
    {
        return $this->with($key, $this->factory->make($view, $data));
    }
    public function withErrors($provider)
    {
        if ($provider instanceof MessageProvider) {
            $this->with('errors', $provider->getMessageBag());
        } else {
            $this->with('errors', new MessageBag((array) $provider));
        }
        return $this;
    }
    public function getFactory()
    {
        return $this->factory;
    }
    public function getEngine()
    {
        return $this->engine;
    }
    public function name()
    {
        return $this->getName();
    }
    public function getName()
    {
        return $this->view;
    }
    public function getData()
    {
        return $this->data;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function setPath($path)
    {
        $this->path = $path;
    }
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->data);
    }
    public function offsetGet($key)
    {
        return $this->data[$key];
    }
    public function offsetSet($key, $value)
    {
        $this->with($key, $value);
    }
    public function offsetUnset($key)
    {
        unset($this->data[$key]);
    }
    public function &__get($key)
    {
        return $this->data[$key];
    }
    public function __set($key, $value)
    {
        $this->with($key, $value);
    }
    public function __isset($key)
    {
        return isset($this->data[$key]);
    }
    public function __unset($key)
    {
        unset($this->data[$key]);
    }
    public function __call($method, $parameters)
    {
        if (starts_with($method, 'with')) {
            return $this->with(snake_case(substr($method, 4)), $parameters[0]);
        }
        throw new \BadMethodCallException("Method [{$method}] does not exist on view.");
    }
    public function __toString()
    {
        return $this->render();
    }
}
namespace Illuminate\View\Engines;

interface EngineInterface
{
    public function get($path, array $data = array());
}
namespace Illuminate\View\Engines;

class PhpEngine implements EngineInterface
{
    public function get($path, array $data = array())
    {
        return $this->evaluatePath($path, $data);
    }
    protected function evaluatePath($__path, $__data)
    {
        $obLevel = ob_get_level();
        ob_start();
        extract($__data);
        try {
            include $__path;
        } catch (\Exception $e) {
            $this->handleViewException($e, $obLevel);
        }
        return ltrim(ob_get_clean());
    }
    protected function handleViewException($e, $obLevel)
    {
        while (ob_get_level() > $obLevel) {
            ob_end_clean();
        }
        throw $e;
    }
}
namespace Symfony\Component\HttpFoundation;

class Response
{
    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102;
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTI_STATUS = 207;
    const HTTP_ALREADY_REPORTED = 208;
    const HTTP_IM_USED = 226;
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_RESERVED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_I_AM_A_TEAPOT = 418;
    const HTTP_UNPROCESSABLE_ENTITY = 422;
    const HTTP_LOCKED = 423;
    const HTTP_FAILED_DEPENDENCY = 424;
    const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;
    const HTTP_UPGRADE_REQUIRED = 426;
    const HTTP_PRECONDITION_REQUIRED = 428;
    const HTTP_TOO_MANY_REQUESTS = 429;
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;
    const HTTP_INSUFFICIENT_STORAGE = 507;
    const HTTP_LOOP_DETECTED = 508;
    const HTTP_NOT_EXTENDED = 510;
    const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;
    public $headers;
    protected $content;
    protected $version;
    protected $statusCode;
    protected $statusText;
    protected $charset;
    public static $statusTexts = array(100 => 'Continue', 101 => 'Switching Protocols', 102 => 'Processing', 200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content', 207 => 'Multi-Status', 208 => 'Already Reported', 226 => 'IM Used', 300 => 'Multiple Choices', 301 => 'Moved Permanently', 302 => 'Found', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 306 => 'Reserved', 307 => 'Temporary Redirect', 308 => 'Permanent Redirect', 400 => 'Bad Request', 401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable', 407 => 'Proxy Authentication Required', 408 => 'Request Timeout', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 413 => 'Request Entity Too Large', 414 => 'Request-URI Too Long', 415 => 'Unsupported Media Type', 416 => 'Requested Range Not Satisfiable', 417 => 'Expectation Failed', 418 => 'I\'m a teapot', 422 => 'Unprocessable Entity', 423 => 'Locked', 424 => 'Failed Dependency', 425 => 'Reserved for WebDAV advanced collections expired proposal', 426 => 'Upgrade Required', 428 => 'Precondition Required', 429 => 'Too Many Requests', 431 => 'Request Header Fields Too Large', 500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 504 => 'Gateway Timeout', 505 => 'HTTP Version Not Supported', 506 => 'Variant Also Negotiates (Experimental)', 507 => 'Insufficient Storage', 508 => 'Loop Detected', 510 => 'Not Extended', 511 => 'Network Authentication Required');
    public function __construct($content = '', $status = 200, $headers = array())
    {
        $this->headers = new ResponseHeaderBag($headers);
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->setProtocolVersion('1.0');
        if (!$this->headers->has('Date')) {
            $this->setDate(new \DateTime(null, new \DateTimeZone('UTC')));
        }
    }
    public static function create($content = '', $status = 200, $headers = array())
    {
        return new static($content, $status, $headers);
    }
    public function __toString()
    {
        return sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText) . '
' . $this->headers . '
' . $this->getContent();
    }
    public function __clone()
    {
        $this->headers = clone $this->headers;
    }
    public function prepare(Request $request)
    {
        $headers = $this->headers;
        if ($this->isInformational() || in_array($this->statusCode, array(204, 304))) {
            $this->setContent(null);
            $headers->remove('Content-Type');
            $headers->remove('Content-Length');
        } else {
            if (!$headers->has('Content-Type')) {
                $format = $request->getRequestFormat();
                if (null !== $format && ($mimeType = $request->getMimeType($format))) {
                    $headers->set('Content-Type', $mimeType);
                }
            }
            $charset = $this->charset ?: 'UTF-8';
            if (!$headers->has('Content-Type')) {
                $headers->set('Content-Type', 'text/html; charset=' . $charset);
            } elseif (0 === stripos($headers->get('Content-Type'), 'text/') && false === stripos($headers->get('Content-Type'), 'charset')) {
                $headers->set('Content-Type', $headers->get('Content-Type') . '; charset=' . $charset);
            }
            if ($headers->has('Transfer-Encoding')) {
                $headers->remove('Content-Length');
            }
            if ($request->isMethod('HEAD')) {
                $length = $headers->get('Content-Length');
                $this->setContent(null);
                if ($length) {
                    $headers->set('Content-Length', $length);
                }
            }
        }
        if ('HTTP/1.0' != $request->server->get('SERVER_PROTOCOL')) {
            $this->setProtocolVersion('1.1');
        }
        if ('1.0' == $this->getProtocolVersion() && 'no-cache' == $this->headers->get('Cache-Control')) {
            $this->headers->set('pragma', 'no-cache');
            $this->headers->set('expires', -1);
        }
        $this->ensureIEOverSSLCompatibility($request);
        return $this;
    }
    public function sendHeaders()
    {
        if (headers_sent()) {
            return $this;
        }
        header(sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText), true, $this->statusCode);
        foreach ($this->headers->allPreserveCase() as $name => $values) {
            foreach ($values as $value) {
                header($name . ': ' . $value, false, $this->statusCode);
            }
        }
        foreach ($this->headers->getCookies() as $cookie) {
            setcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
        }
        return $this;
    }
    public function sendContent()
    {
        echo $this->content;
        return $this;
    }
    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif ('cli' !== PHP_SAPI) {
            static::closeOutputBuffers(0, true);
            flush();
        }
        return $this;
    }
    public function setContent($content)
    {
        if (null !== $content && !is_string($content) && !is_numeric($content) && !is_callable(array($content, '__toString'))) {
            throw new \UnexpectedValueException(sprintf('The Response content must be a string or object implementing __toString(), "%s" given.', gettype($content)));
        }
        $this->content = (string) $content;
        return $this;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function setProtocolVersion($version)
    {
        $this->version = $version;
        return $this;
    }
    public function getProtocolVersion()
    {
        return $this->version;
    }
    public function setStatusCode($code, $text = null)
    {
        $this->statusCode = $code = (int) $code;
        if ($this->isInvalid()) {
            throw new \InvalidArgumentException(sprintf('The HTTP status code "%s" is not valid.', $code));
        }
        if (null === $text) {
            $this->statusText = isset(self::$statusTexts[$code]) ? self::$statusTexts[$code] : '';
            return $this;
        }
        if (false === $text) {
            $this->statusText = '';
            return $this;
        }
        $this->statusText = $text;
        return $this;
    }
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    public function setCharset($charset)
    {
        $this->charset = $charset;
        return $this;
    }
    public function getCharset()
    {
        return $this->charset;
    }
    public function isCacheable()
    {
        if (!in_array($this->statusCode, array(200, 203, 300, 301, 302, 404, 410))) {
            return false;
        }
        if ($this->headers->hasCacheControlDirective('no-store') || $this->headers->getCacheControlDirective('private')) {
            return false;
        }
        return $this->isValidateable() || $this->isFresh();
    }
    public function isFresh()
    {
        return $this->getTtl() > 0;
    }
    public function isValidateable()
    {
        return $this->headers->has('Last-Modified') || $this->headers->has('ETag');
    }
    public function setPrivate()
    {
        $this->headers->removeCacheControlDirective('public');
        $this->headers->addCacheControlDirective('private');
        return $this;
    }
    public function setPublic()
    {
        $this->headers->addCacheControlDirective('public');
        $this->headers->removeCacheControlDirective('private');
        return $this;
    }
    public function mustRevalidate()
    {
        return $this->headers->hasCacheControlDirective('must-revalidate') || $this->headers->has('proxy-revalidate');
    }
    public function getDate()
    {
        return $this->headers->getDate('Date', new \DateTime());
    }
    public function setDate(\DateTime $date)
    {
        $date->setTimezone(new \DateTimeZone('UTC'));
        $this->headers->set('Date', $date->format('D, d M Y H:i:s') . ' GMT');
        return $this;
    }
    public function getAge()
    {
        if (null !== ($age = $this->headers->get('Age'))) {
            return (int) $age;
        }
        return max(time() - $this->getDate()->format('U'), 0);
    }
    public function expire()
    {
        if ($this->isFresh()) {
            $this->headers->set('Age', $this->getMaxAge());
        }
        return $this;
    }
    public function getExpires()
    {
        try {
            return $this->headers->getDate('Expires');
        } catch (\RuntimeException $e) {
            return \DateTime::createFromFormat(DATE_RFC2822, 'Sat, 01 Jan 00 00:00:00 +0000');
        }
    }
    public function setExpires(\DateTime $date = null)
    {
        if (null === $date) {
            $this->headers->remove('Expires');
        } else {
            $date = clone $date;
            $date->setTimezone(new \DateTimeZone('UTC'));
            $this->headers->set('Expires', $date->format('D, d M Y H:i:s') . ' GMT');
        }
        return $this;
    }
    public function getMaxAge()
    {
        if ($this->headers->hasCacheControlDirective('s-maxage')) {
            return (int) $this->headers->getCacheControlDirective('s-maxage');
        }
        if ($this->headers->hasCacheControlDirective('max-age')) {
            return (int) $this->headers->getCacheControlDirective('max-age');
        }
        if (null !== $this->getExpires()) {
            return $this->getExpires()->format('U') - $this->getDate()->format('U');
        }
    }
    public function setMaxAge($value)
    {
        $this->headers->addCacheControlDirective('max-age', $value);
        return $this;
    }
    public function setSharedMaxAge($value)
    {
        $this->setPublic();
        $this->headers->addCacheControlDirective('s-maxage', $value);
        return $this;
    }
    public function getTtl()
    {
        if (null !== ($maxAge = $this->getMaxAge())) {
            return $maxAge - $this->getAge();
        }
    }
    public function setTtl($seconds)
    {
        $this->setSharedMaxAge($this->getAge() + $seconds);
        return $this;
    }
    public function setClientTtl($seconds)
    {
        $this->setMaxAge($this->getAge() + $seconds);
        return $this;
    }
    public function getLastModified()
    {
        return $this->headers->getDate('Last-Modified');
    }
    public function setLastModified(\DateTime $date = null)
    {
        if (null === $date) {
            $this->headers->remove('Last-Modified');
        } else {
            $date = clone $date;
            $date->setTimezone(new \DateTimeZone('UTC'));
            $this->headers->set('Last-Modified', $date->format('D, d M Y H:i:s') . ' GMT');
        }
        return $this;
    }
    public function getEtag()
    {
        return $this->headers->get('ETag');
    }
    public function setEtag($etag = null, $weak = false)
    {
        if (null === $etag) {
            $this->headers->remove('Etag');
        } else {
            if (0 !== strpos($etag, '"')) {
                $etag = '"' . $etag . '"';
            }
            $this->headers->set('ETag', (true === $weak ? 'W/' : '') . $etag);
        }
        return $this;
    }
    public function setCache(array $options)
    {
        if ($diff = array_diff(array_keys($options), array('etag', 'last_modified', 'max_age', 's_maxage', 'private', 'public'))) {
            throw new \InvalidArgumentException(sprintf('Response does not support the following options: "%s".', implode('", "', array_values($diff))));
        }
        if (isset($options['etag'])) {
            $this->setEtag($options['etag']);
        }
        if (isset($options['last_modified'])) {
            $this->setLastModified($options['last_modified']);
        }
        if (isset($options['max_age'])) {
            $this->setMaxAge($options['max_age']);
        }
        if (isset($options['s_maxage'])) {
            $this->setSharedMaxAge($options['s_maxage']);
        }
        if (isset($options['public'])) {
            if ($options['public']) {
                $this->setPublic();
            } else {
                $this->setPrivate();
            }
        }
        if (isset($options['private'])) {
            if ($options['private']) {
                $this->setPrivate();
            } else {
                $this->setPublic();
            }
        }
        return $this;
    }
    public function setNotModified()
    {
        $this->setStatusCode(304);
        $this->setContent(null);
        foreach (array('Allow', 'Content-Encoding', 'Content-Language', 'Content-Length', 'Content-MD5', 'Content-Type', 'Last-Modified') as $header) {
            $this->headers->remove($header);
        }
        return $this;
    }
    public function hasVary()
    {
        return null !== $this->headers->get('Vary');
    }
    public function getVary()
    {
        if (!($vary = $this->headers->get('Vary', null, false))) {
            return array();
        }
        $ret = array();
        foreach ($vary as $item) {
            $ret = array_merge($ret, preg_split('/[\\s,]+/', $item));
        }
        return $ret;
    }
    public function setVary($headers, $replace = true)
    {
        $this->headers->set('Vary', $headers, $replace);
        return $this;
    }
    public function isNotModified(Request $request)
    {
        if (!$request->isMethodSafe()) {
            return false;
        }
        $notModified = false;
        $lastModified = $this->headers->get('Last-Modified');
        $modifiedSince = $request->headers->get('If-Modified-Since');
        if ($etags = $request->getEtags()) {
            $notModified = in_array($this->getEtag(), $etags) || in_array('*', $etags);
        }
        if ($modifiedSince && $lastModified) {
            $notModified = strtotime($modifiedSince) >= strtotime($lastModified) && (!$etags || $notModified);
        }
        if ($notModified) {
            $this->setNotModified();
        }
        return $notModified;
    }
    public function isInvalid()
    {
        return $this->statusCode < 100 || $this->statusCode >= 600;
    }
    public function isInformational()
    {
        return $this->statusCode >= 100 && $this->statusCode < 200;
    }
    public function isSuccessful()
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }
    public function isRedirection()
    {
        return $this->statusCode >= 300 && $this->statusCode < 400;
    }
    public function isClientError()
    {
        return $this->statusCode >= 400 && $this->statusCode < 500;
    }
    public function isServerError()
    {
        return $this->statusCode >= 500 && $this->statusCode < 600;
    }
    public function isOk()
    {
        return 200 === $this->statusCode;
    }
    public function isForbidden()
    {
        return 403 === $this->statusCode;
    }
    public function isNotFound()
    {
        return 404 === $this->statusCode;
    }
    public function isRedirect($location = null)
    {
        return in_array($this->statusCode, array(201, 301, 302, 303, 307, 308)) && (null === $location ?: $location == $this->headers->get('Location'));
    }
    public function isEmpty()
    {
        return in_array($this->statusCode, array(204, 304));
    }
    public static function closeOutputBuffers($targetLevel, $flush)
    {
        $status = ob_get_status(true);
        $level = count($status);
        while ($level-- > $targetLevel && (!empty($status[$level]['del']) || isset($status[$level]['flags']) && $status[$level]['flags'] & PHP_OUTPUT_HANDLER_REMOVABLE && $status[$level]['flags'] & ($flush ? PHP_OUTPUT_HANDLER_FLUSHABLE : PHP_OUTPUT_HANDLER_CLEANABLE))) {
            if ($flush) {
                ob_end_flush();
            } else {
                ob_end_clean();
            }
        }
    }
    protected function ensureIEOverSSLCompatibility(Request $request)
    {
        if (false !== stripos($this->headers->get('Content-Disposition'), 'attachment') && preg_match('/MSIE (.*?);/i', $request->server->get('HTTP_USER_AGENT'), $match) == 1 && true === $request->isSecure()) {
            if (intval(preg_replace('/(MSIE )(.*?);/', '$2', $match[0])) < 9) {
                $this->headers->remove('Cache-Control');
            }
        }
    }
}
namespace Illuminate\Http;

use Symfony\Component\HttpFoundation\Cookie;
trait ResponseTrait
{
    public function header($key, $value, $replace = true)
    {
        $this->headers->set($key, $value, $replace);
        return $this;
    }
    public function withCookie(Cookie $cookie)
    {
        $this->headers->setCookie($cookie);
        return $this;
    }
}
namespace Illuminate\Http;

use ArrayObject;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;
class Response extends \Symfony\Component\HttpFoundation\Response
{
    use ResponseTrait;
    public $original;
    public function setContent($content)
    {
        $this->original = $content;
        if ($this->shouldBeJson($content)) {
            $this->headers->set('Content-Type', 'application/json');
            $content = $this->morphToJson($content);
        } elseif ($content instanceof Renderable) {
            $content = $content->render();
        }
        return parent::setContent($content);
    }
    protected function morphToJson($content)
    {
        if ($content instanceof Jsonable) {
            return $content->toJson();
        }
        return json_encode($content);
    }
    protected function shouldBeJson($content)
    {
        return $content instanceof Jsonable || $content instanceof ArrayObject || is_array($content);
    }
    public function getOriginalContent()
    {
        return $this->original;
    }
}
namespace Symfony\Component\HttpFoundation;

class ResponseHeaderBag extends HeaderBag
{
    const COOKIES_FLAT = 'flat';
    const COOKIES_ARRAY = 'array';
    const DISPOSITION_ATTACHMENT = 'attachment';
    const DISPOSITION_INLINE = 'inline';
    protected $computedCacheControl = array();
    protected $cookies = array();
    protected $headerNames = array();
    public function __construct(array $headers = array())
    {
        parent::__construct($headers);
        if (!isset($this->headers['cache-control'])) {
            $this->set('Cache-Control', '');
        }
    }
    public function __toString()
    {
        $cookies = '';
        foreach ($this->getCookies() as $cookie) {
            $cookies .= 'Set-Cookie: ' . $cookie . '
';
        }
        ksort($this->headerNames);
        return parent::__toString() . $cookies;
    }
    public function allPreserveCase()
    {
        return array_combine($this->headerNames, $this->headers);
    }
    public function replace(array $headers = array())
    {
        $this->headerNames = array();
        parent::replace($headers);
        if (!isset($this->headers['cache-control'])) {
            $this->set('Cache-Control', '');
        }
    }
    public function set($key, $values, $replace = true)
    {
        parent::set($key, $values, $replace);
        $uniqueKey = strtr(strtolower($key), '_', '-');
        $this->headerNames[$uniqueKey] = $key;
        if (in_array($uniqueKey, array('cache-control', 'etag', 'last-modified', 'expires'))) {
            $computed = $this->computeCacheControlValue();
            $this->headers['cache-control'] = array($computed);
            $this->headerNames['cache-control'] = 'Cache-Control';
            $this->computedCacheControl = $this->parseCacheControl($computed);
        }
    }
    public function remove($key)
    {
        parent::remove($key);
        $uniqueKey = strtr(strtolower($key), '_', '-');
        unset($this->headerNames[$uniqueKey]);
        if ('cache-control' === $uniqueKey) {
            $this->computedCacheControl = array();
        }
    }
    public function hasCacheControlDirective($key)
    {
        return array_key_exists($key, $this->computedCacheControl);
    }
    public function getCacheControlDirective($key)
    {
        return array_key_exists($key, $this->computedCacheControl) ? $this->computedCacheControl[$key] : null;
    }
    public function setCookie(Cookie $cookie)
    {
        $this->cookies[$cookie->getDomain()][$cookie->getPath()][$cookie->getName()] = $cookie;
    }
    public function removeCookie($name, $path = '/', $domain = null)
    {
        if (null === $path) {
            $path = '/';
        }
        unset($this->cookies[$domain][$path][$name]);
        if (empty($this->cookies[$domain][$path])) {
            unset($this->cookies[$domain][$path]);
            if (empty($this->cookies[$domain])) {
                unset($this->cookies[$domain]);
            }
        }
    }
    public function getCookies($format = self::COOKIES_FLAT)
    {
        if (!in_array($format, array(self::COOKIES_FLAT, self::COOKIES_ARRAY))) {
            throw new \InvalidArgumentException(sprintf('Format "%s" invalid (%s).', $format, implode(', ', array(self::COOKIES_FLAT, self::COOKIES_ARRAY))));
        }
        if (self::COOKIES_ARRAY === $format) {
            return $this->cookies;
        }
        $flattenedCookies = array();
        foreach ($this->cookies as $path) {
            foreach ($path as $cookies) {
                foreach ($cookies as $cookie) {
                    $flattenedCookies[] = $cookie;
                }
            }
        }
        return $flattenedCookies;
    }
    public function clearCookie($name, $path = '/', $domain = null, $secure = false, $httpOnly = true)
    {
        $this->setCookie(new Cookie($name, null, 1, $path, $domain, $secure, $httpOnly));
    }
    public function makeDisposition($disposition, $filename, $filenameFallback = '')
    {
        if (!in_array($disposition, array(self::DISPOSITION_ATTACHMENT, self::DISPOSITION_INLINE))) {
            throw new \InvalidArgumentException(sprintf('The disposition must be either "%s" or "%s".', self::DISPOSITION_ATTACHMENT, self::DISPOSITION_INLINE));
        }
        if ('' == $filenameFallback) {
            $filenameFallback = $filename;
        }
        if (!preg_match('/^[\\x20-\\x7e]*$/', $filenameFallback)) {
            throw new \InvalidArgumentException('The filename fallback must only contain ASCII characters.');
        }
        if (false !== strpos($filenameFallback, '%')) {
            throw new \InvalidArgumentException('The filename fallback cannot contain the "%" character.');
        }
        if (false !== strpos($filename, '/') || false !== strpos($filename, '\\') || false !== strpos($filenameFallback, '/') || false !== strpos($filenameFallback, '\\')) {
            throw new \InvalidArgumentException('The filename and the fallback cannot contain the "/" and "\\" characters.');
        }
        $output = sprintf('%s; filename="%s"', $disposition, str_replace('"', '\\"', $filenameFallback));
        if ($filename !== $filenameFallback) {
            $output .= sprintf('; filename*=utf-8\'\'%s', rawurlencode($filename));
        }
        return $output;
    }
    protected function computeCacheControlValue()
    {
        if (!$this->cacheControl && !$this->has('ETag') && !$this->has('Last-Modified') && !$this->has('Expires')) {
            return 'no-cache';
        }
        if (!$this->cacheControl) {
            return 'private, must-revalidate';
        }
        $header = $this->getCacheControlHeader();
        if (isset($this->cacheControl['public']) || isset($this->cacheControl['private'])) {
            return $header;
        }
        if (!isset($this->cacheControl['s-maxage'])) {
            return $header . ', private';
        }
        return $header;
    }
}
namespace Symfony\Component\HttpFoundation;

class Cookie
{
    protected $name;
    protected $value;
    protected $domain;
    protected $expire;
    protected $path;
    protected $secure;
    protected $httpOnly;
    public function __construct($name, $value = null, $expire = 0, $path = '/', $domain = null, $secure = false, $httpOnly = true)
    {
        if (preg_match('/[=,; 	
]/', $name)) {
            throw new \InvalidArgumentException(sprintf('The cookie name "%s" contains invalid characters.', $name));
        }
        if (empty($name)) {
            throw new \InvalidArgumentException('The cookie name cannot be empty.');
        }
        if ($expire instanceof \DateTime) {
            $expire = $expire->format('U');
        } elseif (!is_numeric($expire)) {
            $expire = strtotime($expire);
            if (false === $expire || -1 === $expire) {
                throw new \InvalidArgumentException('The cookie expiration time is not valid.');
            }
        }
        $this->name = $name;
        $this->value = $value;
        $this->domain = $domain;
        $this->expire = $expire;
        $this->path = empty($path) ? '/' : $path;
        $this->secure = (bool) $secure;
        $this->httpOnly = (bool) $httpOnly;
    }
    public function __toString()
    {
        $str = urlencode($this->getName()) . '=';
        if ('' === (string) $this->getValue()) {
            $str .= 'deleted; expires=' . gmdate('D, d-M-Y H:i:s T', time() - 31536001);
        } else {
            $str .= urlencode($this->getValue());
            if ($this->getExpiresTime() !== 0) {
                $str .= '; expires=' . gmdate('D, d-M-Y H:i:s T', $this->getExpiresTime());
            }
        }
        if ($this->path) {
            $str .= '; path=' . $this->path;
        }
        if ($this->getDomain()) {
            $str .= '; domain=' . $this->getDomain();
        }
        if (true === $this->isSecure()) {
            $str .= '; secure';
        }
        if (true === $this->isHttpOnly()) {
            $str .= '; httponly';
        }
        return $str;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function getDomain()
    {
        return $this->domain;
    }
    public function getExpiresTime()
    {
        return $this->expire;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function isSecure()
    {
        return $this->secure;
    }
    public function isHttpOnly()
    {
        return $this->httpOnly;
    }
    public function isCleared()
    {
        return $this->expire < time();
    }
}
namespace Whoops;

use Whoops\Handler\HandlerInterface;
use Whoops\Handler\Handler;
use Whoops\Handler\CallbackHandler;
use Whoops\Exception\Inspector;
use Whoops\Exception\ErrorException;
use InvalidArgumentException;
use Exception;
class Run
{
    const EXCEPTION_HANDLER = 'handleException';
    const ERROR_HANDLER = 'handleError';
    const SHUTDOWN_HANDLER = 'handleShutdown';
    protected $isRegistered;
    protected $allowQuit = true;
    protected $sendOutput = true;
    protected $sendHttpCode = 500;
    protected $handlerStack = array();
    protected $silencedPatterns = array();
    public function pushHandler($handler)
    {
        if (is_callable($handler)) {
            $handler = new CallbackHandler($handler);
        }
        if (!$handler instanceof HandlerInterface) {
            throw new InvalidArgumentException('Argument to ' . __METHOD__ . ' must be a callable, or instance of' . 'Whoops\\Handler\\HandlerInterface');
        }
        $this->handlerStack[] = $handler;
        return $this;
    }
    public function popHandler()
    {
        return array_pop($this->handlerStack);
    }
    public function getHandlers()
    {
        return $this->handlerStack;
    }
    public function clearHandlers()
    {
        $this->handlerStack = array();
        return $this;
    }
    protected function getInspector(Exception $exception)
    {
        return new Inspector($exception);
    }
    public function register()
    {
        if (!$this->isRegistered) {
            class_exists('\\Whoops\\Exception\\ErrorException');
            class_exists('\\Whoops\\Exception\\FrameCollection');
            class_exists('\\Whoops\\Exception\\Frame');
            class_exists('\\Whoops\\Exception\\Inspector');
            set_error_handler(array($this, self::ERROR_HANDLER));
            set_exception_handler(array($this, self::EXCEPTION_HANDLER));
            register_shutdown_function(array($this, self::SHUTDOWN_HANDLER));
            $this->isRegistered = true;
        }
        return $this;
    }
    public function unregister()
    {
        if ($this->isRegistered) {
            restore_exception_handler();
            restore_error_handler();
            $this->isRegistered = false;
        }
        return $this;
    }
    public function allowQuit($exit = null)
    {
        if (func_num_args() == 0) {
            return $this->allowQuit;
        }
        return $this->allowQuit = (bool) $exit;
    }
    public function silenceErrorsInPaths($patterns, $levels = 10240)
    {
        $this->silencedPatterns = array_merge($this->silencedPatterns, array_map(function ($pattern) use($levels) {
            return array('pattern' => $pattern, 'levels' => $levels);
        }, (array) $patterns));
        return $this;
    }
    public function sendHttpCode($code = null)
    {
        if (func_num_args() == 0) {
            return $this->sendHttpCode;
        }
        if (!$code) {
            return $this->sendHttpCode = false;
        }
        if ($code === true) {
            $code = 500;
        }
        if ($code < 400 || 600 <= $code) {
            throw new InvalidArgumentException("Invalid status code '{$code}', must be 4xx or 5xx");
        }
        return $this->sendHttpCode = $code;
    }
    public function writeToOutput($send = null)
    {
        if (func_num_args() == 0) {
            return $this->sendOutput;
        }
        return $this->sendOutput = (bool) $send;
    }
    public function handleException(Exception $exception)
    {
        $inspector = $this->getInspector($exception);
        ob_start();
        $handlerResponse = null;
        foreach (array_reverse($this->handlerStack) as $handler) {
            $handler->setRun($this);
            $handler->setInspector($inspector);
            $handler->setException($exception);
            $handlerResponse = $handler->handle($exception);
            if (in_array($handlerResponse, array(Handler::LAST_HANDLER, Handler::QUIT))) {
                break;
            }
        }
        $willQuit = $handlerResponse == Handler::QUIT && $this->allowQuit();
        $output = ob_get_clean();
        if ($this->writeToOutput()) {
            if ($willQuit) {
                while (ob_get_level() > 0) {
                    ob_end_clean();
                }
            }
            $this->writeToOutputNow($output);
        }
        if ($willQuit) {
            die(1);
        }
        return $output;
    }
    public function handleError($level, $message, $file = null, $line = null)
    {
        if ($level & error_reporting()) {
            foreach ($this->silencedPatterns as $entry) {
                $pathMatches = (bool) preg_match($entry['pattern'], $file);
                $levelMatches = $level & $entry['levels'];
                if ($pathMatches && $levelMatches) {
                    return true;
                }
            }
            $exception = new ErrorException($message, $level, 0, $file, $line);
            if ($this->canThrowExceptions) {
                throw $exception;
            } else {
                $this->handleException($exception);
            }
        }
    }
    public function handleShutdown()
    {
        $this->canThrowExceptions = false;
        $error = error_get_last();
        if ($error && $this->isLevelFatal($error['type'])) {
            $this->handleError($error['type'], $error['message'], $error['file'], $error['line']);
        }
    }
    private $canThrowExceptions = true;
    private function writeToOutputNow($output)
    {
        if ($this->sendHttpCode() && \Whoops\Util\Misc::canSendHeaders()) {
            $httpCode = $this->sendHttpCode();
            if (function_exists('http_response_code')) {
                http_response_code($httpCode);
            } else {
                header('X-Ignore-This: 1', true, $httpCode);
            }
        }
        echo $output;
        return $this;
    }
    private static function isLevelFatal($level)
    {
        return in_array($level, array(E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING));
    }
}
namespace Whoops\Handler;

use Whoops\Exception\Inspector;
use Whoops\Run;
use Exception;
interface HandlerInterface
{
    public function handle();
    public function setRun(Run $run);
    public function setException(Exception $exception);
    public function setInspector(Inspector $inspector);
}
namespace Whoops\Handler;

use Whoops\Handler\HandlerInterface;
use Whoops\Exception\Inspector;
use Whoops\Run;
use Exception;
abstract class Handler implements HandlerInterface
{
    const DONE = 16;
    const LAST_HANDLER = 32;
    const QUIT = 48;
    private $run;
    private $inspector;
    private $exception;
    public function setRun(Run $run)
    {
        $this->run = $run;
    }
    protected function getRun()
    {
        return $this->run;
    }
    public function setInspector(Inspector $inspector)
    {
        $this->inspector = $inspector;
    }
    protected function getInspector()
    {
        return $this->inspector;
    }
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
    }
    protected function getException()
    {
        return $this->exception;
    }
}
namespace Whoops\Handler;

use Whoops\Handler\Handler;
use Whoops\Util\Misc;
use Whoops\Util\TemplateHelper;
use Whoops\Exception\Formatter;
use InvalidArgumentException;
use RuntimeException;
class PrettyPageHandler extends Handler
{
    private $searchPaths = array();
    private $resourceCache = array();
    private $customCss = null;
    private $extraTables = array();
    private $handleUnconditionally = false;
    private $pageTitle = 'Whoops! There was an error.';
    protected $editor;
    protected $editors = array('sublime' => 'subl://open?url=file://%file&line=%line', 'textmate' => 'txmt://open?url=file://%file&line=%line', 'emacs' => 'emacs://open?url=file://%file&line=%line', 'macvim' => 'mvim://open/?url=file://%file&line=%line');
    public function __construct()
    {
        if (ini_get('xdebug.file_link_format') || extension_loaded('xdebug')) {
            $this->editors['xdebug'] = function ($file, $line) {
                return str_replace(array('%f', '%l'), array($file, $line), ini_get('xdebug.file_link_format'));
            };
        }
        $this->searchPaths[] = '/home/vagrant/html/streams/vendor/filp/whoops/src/Whoops/Handler' . '/../Resources';
    }
    public function handle()
    {
        if (!$this->handleUnconditionally()) {
            if (php_sapi_name() === 'cli') {
                if (isset($_ENV['whoops-test'])) {
                    throw new \Exception('Use handleUnconditionally instead of whoops-test' . ' environment variable');
                }
                return Handler::DONE;
            }
        }
        $helper = new TemplateHelper();
        $templateFile = $this->getResource('views/layout.html.php');
        $cssFile = $this->getResource('css/whoops.base.css');
        $zeptoFile = $this->getResource('js/zepto.min.js');
        $jsFile = $this->getResource('js/whoops.base.js');
        if ($this->customCss) {
            $customCssFile = $this->getResource($this->customCss);
        }
        $inspector = $this->getInspector();
        $frames = $inspector->getFrames();
        $code = $inspector->getException()->getCode();
        if ($inspector->getException() instanceof \ErrorException) {
            $code = Misc::translateErrorCode($code);
        }
        $vars = array('page_title' => $this->getPageTitle(), 'stylesheet' => file_get_contents($cssFile), 'zepto' => file_get_contents($zeptoFile), 'javascript' => file_get_contents($jsFile), 'header' => $this->getResource('views/header.html.php'), 'frame_list' => $this->getResource('views/frame_list.html.php'), 'frame_code' => $this->getResource('views/frame_code.html.php'), 'env_details' => $this->getResource('views/env_details.html.php'), 'title' => $this->getPageTitle(), 'name' => explode('\\', $inspector->getExceptionName()), 'message' => $inspector->getException()->getMessage(), 'code' => $code, 'plain_exception' => Formatter::formatExceptionPlain($inspector), 'frames' => $frames, 'has_frames' => !!count($frames), 'handler' => $this, 'handlers' => $this->getRun()->getHandlers(), 'tables' => array('Server/Request Data' => $_SERVER, 'GET Data' => $_GET, 'POST Data' => $_POST, 'Files' => $_FILES, 'Cookies' => $_COOKIE, 'Session' => isset($_SESSION) ? $_SESSION : array(), 'Environment Variables' => $_ENV));
        if (isset($customCssFile)) {
            $vars['stylesheet'] .= file_get_contents($customCssFile);
        }
        $extraTables = array_map(function ($table) {
            return $table instanceof \Closure ? $table() : $table;
        }, $this->getDataTables());
        $vars['tables'] = array_merge($extraTables, $vars['tables']);
        $helper->setVariables($vars);
        $helper->render($templateFile);
        return Handler::QUIT;
    }
    public function addDataTable($label, array $data)
    {
        $this->extraTables[$label] = $data;
    }
    public function addDataTableCallback($label, $callback)
    {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException('Expecting callback argument to be callable');
        }
        $this->extraTables[$label] = function () use($callback) {
            try {
                $result = call_user_func($callback);
                return is_array($result) || $result instanceof \Traversable ? $result : array();
            } catch (\Exception $e) {
                return array();
            }
        };
    }
    public function getDataTables($label = null)
    {
        if ($label !== null) {
            return isset($this->extraTables[$label]) ? $this->extraTables[$label] : array();
        }
        return $this->extraTables;
    }
    public function handleUnconditionally($value = null)
    {
        if (func_num_args() == 0) {
            return $this->handleUnconditionally;
        }
        $this->handleUnconditionally = (bool) $value;
    }
    public function addEditor($identifier, $resolver)
    {
        $this->editors[$identifier] = $resolver;
    }
    public function setEditor($editor)
    {
        if (!is_callable($editor) && !isset($this->editors[$editor])) {
            throw new InvalidArgumentException("Unknown editor identifier: {$editor}. Known editors:" . implode(',', array_keys($this->editors)));
        }
        $this->editor = $editor;
    }
    public function getEditorHref($filePath, $line)
    {
        if ($this->editor === null) {
            return false;
        }
        $editor = $this->editor;
        if (is_string($editor)) {
            $editor = $this->editors[$editor];
        }
        if (is_callable($editor)) {
            $editor = call_user_func($editor, $filePath, $line);
        }
        if (!is_string($editor)) {
            throw new InvalidArgumentException(__METHOD__ . ' should always resolve to a string; got something else instead');
        }
        $editor = str_replace('%line', rawurlencode($line), $editor);
        $editor = str_replace('%file', rawurlencode($filePath), $editor);
        return $editor;
    }
    public function setPageTitle($title)
    {
        $this->pageTitle = (string) $title;
    }
    public function getPageTitle()
    {
        return $this->pageTitle;
    }
    public function addResourcePath($path)
    {
        if (!is_dir($path)) {
            throw new InvalidArgumentException("'{$path}' is not a valid directory");
        }
        array_unshift($this->searchPaths, $path);
    }
    public function addCustomCss($name)
    {
        $this->customCss = $name;
    }
    public function getResourcePaths()
    {
        return $this->searchPaths;
    }
    protected function getResource($resource)
    {
        if (isset($this->resourceCache[$resource])) {
            return $this->resourceCache[$resource];
        }
        foreach ($this->searchPaths as $path) {
            $fullPath = $path . "/{$resource}";
            if (is_file($fullPath)) {
                $this->resourceCache[$resource] = $fullPath;
                return $fullPath;
            }
        }
        throw new RuntimeException("Could not find resource '{$resource}' in any resource paths." . '(searched: ' . join(', ', $this->searchPaths) . ')');
    }
    public function getResourcesPath()
    {
        $allPaths = $this->getResourcePaths();
        return end($allPaths) ?: null;
    }
    public function setResourcesPath($resourcesPath)
    {
        $this->addResourcePath($resourcesPath);
    }
}
namespace Whoops\Handler;

use Whoops\Handler\Handler;
use Whoops\Exception\Formatter;
class JsonResponseHandler extends Handler
{
    private $returnFrames = false;
    private $onlyForAjaxRequests = false;
    public function addTraceToOutput($returnFrames = null)
    {
        if (func_num_args() == 0) {
            return $this->returnFrames;
        }
        $this->returnFrames = (bool) $returnFrames;
        return $this;
    }
    public function onlyForAjaxRequests($onlyForAjaxRequests = null)
    {
        if (func_num_args() == 0) {
            return $this->onlyForAjaxRequests;
        }
        $this->onlyForAjaxRequests = (bool) $onlyForAjaxRequests;
    }
    private function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    public function handle()
    {
        if ($this->onlyForAjaxRequests() && !$this->isAjaxRequest()) {
            return Handler::DONE;
        }
        $response = array('error' => Formatter::formatExceptionAsDataArray($this->getInspector(), $this->addTraceToOutput()));
        if (\Whoops\Util\Misc::canSendHeaders()) {
            header('Content-Type: application/json');
        }
        echo json_encode($response);
        return Handler::QUIT;
    }
}
namespace Stack;

use Symfony\Component\HttpKernel\HttpKernelInterface;
class Builder
{
    private $specs;
    public function __construct()
    {
        $this->specs = new \SplStack();
    }
    public function unshift()
    {
        if (func_num_args() === 0) {
            throw new \InvalidArgumentException('Missing argument(s) when calling unshift');
        }
        $spec = func_get_args();
        $this->specs->unshift($spec);
        return $this;
    }
    public function push()
    {
        if (func_num_args() === 0) {
            throw new \InvalidArgumentException('Missing argument(s) when calling push');
        }
        $spec = func_get_args();
        $this->specs->push($spec);
        return $this;
    }
    public function resolve(HttpKernelInterface $app)
    {
        $middlewares = array($app);
        foreach ($this->specs as $spec) {
            $args = $spec;
            $firstArg = array_shift($args);
            if (is_callable($firstArg)) {
                $app = $firstArg($app);
            } else {
                $kernelClass = $firstArg;
                array_unshift($args, $app);
                $reflection = new \ReflectionClass($kernelClass);
                $app = $reflection->newInstanceArgs($args);
            }
            array_unshift($middlewares, $app);
        }
        return new StackedHttpKernel($app, $middlewares);
    }
}
namespace Stack;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class StackedHttpKernel implements HttpKernelInterface, TerminableInterface
{
    private $app;
    private $middlewares = array();
    public function __construct(HttpKernelInterface $app, array $middlewares)
    {
        $this->app = $app;
        $this->middlewares = $middlewares;
    }
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        return $this->app->handle($request, $type, $catch);
    }
    public function terminate(Request $request, Response $response)
    {
        foreach ($this->middlewares as $kernel) {
            if ($kernel instanceof TerminableInterface) {
                $kernel->terminate($request, $response);
            }
        }
    }
}
namespace Symfony\Component\Security\Core\Util;

class StringUtils
{
    private function __construct()
    {
        
    }
    public static function equals($knownString, $userInput)
    {
        $knownString = (string) $knownString;
        $userInput = (string) $userInput;
        if (function_exists('hash_equals')) {
            return hash_equals($knownString, $userInput);
        }
        $knownLen = strlen($knownString);
        $userLen = strlen($userInput);
        $knownString .= $userInput;
        $result = $knownLen - $userLen;
        for ($i = 0; $i < $userLen; $i++) {
            $result |= ord($knownString[$i]) ^ ord($userInput[$i]);
        }
        return 0 === $result;
    }
}
namespace Symfony\Component\Security\Core\Util;

interface SecureRandomInterface
{
    public function nextBytes($nbBytes);
}
namespace Symfony\Component\Security\Core\Util;

use Psr\Log\LoggerInterface;
final class SecureRandom implements SecureRandomInterface
{
    private $logger;
    private $useOpenSsl;
    private $seed;
    private $seedUpdated;
    private $seedLastUpdatedAt;
    private $seedFile;
    public function __construct($seedFile = null, LoggerInterface $logger = null)
    {
        $this->seedFile = $seedFile;
        $this->logger = $logger;
        if (defined('PHP_WINDOWS_VERSION_BUILD') && version_compare(PHP_VERSION, '5.3.4', '<')) {
            $this->useOpenSsl = false;
        } elseif (!function_exists('openssl_random_pseudo_bytes')) {
            if (null !== $this->logger) {
                $this->logger->notice('It is recommended that you enable the "openssl" extension for random number generation.');
            }
            $this->useOpenSsl = false;
        } else {
            $this->useOpenSsl = true;
        }
    }
    public function nextBytes($nbBytes)
    {
        if ($this->useOpenSsl) {
            $bytes = openssl_random_pseudo_bytes($nbBytes, $strong);
            if (false !== $bytes && true === $strong) {
                return $bytes;
            }
            if (null !== $this->logger) {
                $this->logger->info('OpenSSL did not produce a secure random number.');
            }
        }
        if (null === $this->seed) {
            if (null === $this->seedFile) {
                throw new \RuntimeException('You need to specify a file path to store the seed.');
            }
            if (is_file($this->seedFile)) {
                list($this->seed, $this->seedLastUpdatedAt) = $this->readSeed();
            } else {
                $this->seed = uniqid(mt_rand(), true);
                $this->updateSeed();
            }
        }
        $bytes = '';
        while (strlen($bytes) < $nbBytes) {
            static $incr = 1;
            $bytes .= hash('sha512', $incr++ . $this->seed . uniqid(mt_rand(), true) . $nbBytes, true);
            $this->seed = base64_encode(hash('sha512', $this->seed . $bytes . $nbBytes, true));
            $this->updateSeed();
        }
        return substr($bytes, 0, $nbBytes);
    }
    private function readSeed()
    {
        return json_decode(file_get_contents($this->seedFile));
    }
    private function updateSeed()
    {
        if (!$this->seedUpdated && $this->seedLastUpdatedAt < time() - mt_rand(1, 10)) {
            file_put_contents($this->seedFile, json_encode(array($this->seed, microtime(true))));
        }
        $this->seedUpdated = true;
    }
}
namespace Carbon;

use Closure;
use DateTime;
use DateTimeZone;
use DateInterval;
use DatePeriod;
use InvalidArgumentException;
class Carbon extends DateTime
{
    const SUNDAY = 0;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    protected static $days = array(self::SUNDAY => 'Sunday', self::MONDAY => 'Monday', self::TUESDAY => 'Tuesday', self::WEDNESDAY => 'Wednesday', self::THURSDAY => 'Thursday', self::FRIDAY => 'Friday', self::SATURDAY => 'Saturday');
    protected static $relativeKeywords = array('this', 'next', 'last', 'tomorrow', 'yesterday', '+', '-', 'first', 'last', 'ago');
    const YEARS_PER_CENTURY = 100;
    const YEARS_PER_DECADE = 10;
    const MONTHS_PER_YEAR = 12;
    const WEEKS_PER_YEAR = 52;
    const DAYS_PER_WEEK = 7;
    const HOURS_PER_DAY = 24;
    const MINUTES_PER_HOUR = 60;
    const SECONDS_PER_MINUTE = 60;
    const DEFAULT_TO_STRING_FORMAT = 'Y-m-d H:i:s';
    protected static $toStringFormat = self::DEFAULT_TO_STRING_FORMAT;
    protected static $testNow;
    protected static function safeCreateDateTimeZone($object)
    {
        if ($object instanceof DateTimeZone) {
            return $object;
        }
        $tz = @timezone_open((string) $object);
        if ($tz === false) {
            throw new InvalidArgumentException('Unknown or bad timezone (' . $object . ')');
        }
        return $tz;
    }
    public function __construct($time = null, $tz = null)
    {
        if (static::hasTestNow() && (empty($time) || $time === 'now' || static::hasRelativeKeywords($time))) {
            $testInstance = clone static::getTestNow();
            if (static::hasRelativeKeywords($time)) {
                $testInstance->modify($time);
            }
            if ($tz !== NULL && $tz != static::getTestNow()->tz) {
                $testInstance->setTimezone($tz);
            } else {
                $tz = $testInstance->tz;
            }
            $time = $testInstance->toDateTimeString();
        }
        if ($tz !== null) {
            parent::__construct($time, static::safeCreateDateTimeZone($tz));
        } else {
            parent::__construct($time);
        }
    }
    public static function instance(DateTime $dt)
    {
        return new static($dt->format('Y-m-d H:i:s.u'), $dt->getTimeZone());
    }
    public static function parse($time = null, $tz = null)
    {
        return new static($time, $tz);
    }
    public static function now($tz = null)
    {
        return new static(null, $tz);
    }
    public static function today($tz = null)
    {
        return static::now($tz)->startOfDay();
    }
    public static function tomorrow($tz = null)
    {
        return static::today($tz)->addDay();
    }
    public static function yesterday($tz = null)
    {
        return static::today($tz)->subDay();
    }
    public static function maxValue()
    {
        return static::createFromTimestamp(PHP_INT_MAX);
    }
    public static function minValue()
    {
        return static::createFromTimestamp(~PHP_INT_MAX);
    }
    public static function create($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $tz = null)
    {
        $year = $year === null ? date('Y') : $year;
        $month = $month === null ? date('n') : $month;
        $day = $day === null ? date('j') : $day;
        if ($hour === null) {
            $hour = date('G');
            $minute = $minute === null ? date('i') : $minute;
            $second = $second === null ? date('s') : $second;
        } else {
            $minute = $minute === null ? 0 : $minute;
            $second = $second === null ? 0 : $second;
        }
        return static::createFromFormat('Y-n-j G:i:s', sprintf('%s-%s-%s %s:%02s:%02s', $year, $month, $day, $hour, $minute, $second), $tz);
    }
    public static function createFromDate($year = null, $month = null, $day = null, $tz = null)
    {
        return static::create($year, $month, $day, null, null, null, $tz);
    }
    public static function createFromTime($hour = null, $minute = null, $second = null, $tz = null)
    {
        return static::create(null, null, null, $hour, $minute, $second, $tz);
    }
    public static function createFromFormat($format, $time, $tz = null)
    {
        if ($tz !== null) {
            $dt = parent::createFromFormat($format, $time, static::safeCreateDateTimeZone($tz));
        } else {
            $dt = parent::createFromFormat($format, $time);
        }
        if ($dt instanceof DateTime) {
            return static::instance($dt);
        }
        $errors = static::getLastErrors();
        throw new InvalidArgumentException(implode(PHP_EOL, $errors['errors']));
    }
    public static function createFromTimestamp($timestamp, $tz = null)
    {
        return static::now($tz)->setTimestamp($timestamp);
    }
    public static function createFromTimestampUTC($timestamp)
    {
        return new static('@' . $timestamp);
    }
    public function copy()
    {
        return static::instance($this);
    }
    public function __get($name)
    {
        switch ($name) {
            case 'year':
            case 'month':
            case 'day':
            case 'hour':
            case 'minute':
            case 'second':
            case 'micro':
            case 'dayOfWeek':
            case 'dayOfYear':
            case 'weekOfYear':
            case 'daysInMonth':
            case 'timestamp':
                $formats = array('year' => 'Y', 'month' => 'n', 'day' => 'j', 'hour' => 'G', 'minute' => 'i', 'second' => 's', 'micro' => 'u', 'dayOfWeek' => 'w', 'dayOfYear' => 'z', 'weekOfYear' => 'W', 'daysInMonth' => 't', 'timestamp' => 'U');
                return (int) $this->format($formats[$name]);
            case 'weekOfMonth':
                return (int) ceil($this->day / self::DAYS_PER_WEEK);
            case 'age':
                return (int) $this->diffInYears();
            case 'quarter':
                return (int) ceil($this->month / 3);
            case 'offset':
                return $this->getOffset();
            case 'offsetHours':
                return $this->getOffset() / self::SECONDS_PER_MINUTE / self::MINUTES_PER_HOUR;
            case 'dst':
                return $this->format('I') == '1';
            case 'local':
                return $this->offset == $this->copy()->setTimezone(date_default_timezone_get())->offset;
            case 'utc':
                return $this->offset == 0;
            case 'timezone':
            case 'tz':
                return $this->getTimezone();
            case 'timezoneName':
            case 'tzName':
                return $this->getTimezone()->getName();
            default:
                throw new InvalidArgumentException(sprintf('Unknown getter \'%s\'', $name));
        }
    }
    public function __isset($name)
    {
        try {
            $this->__get($name);
        } catch (InvalidArgumentException $e) {
            return false;
        }
        return true;
    }
    public function __set($name, $value)
    {
        switch ($name) {
            case 'year':
                parent::setDate($value, $this->month, $this->day);
                break;
            case 'month':
                parent::setDate($this->year, $value, $this->day);
                break;
            case 'day':
                parent::setDate($this->year, $this->month, $value);
                break;
            case 'hour':
                parent::setTime($value, $this->minute, $this->second);
                break;
            case 'minute':
                parent::setTime($this->hour, $value, $this->second);
                break;
            case 'second':
                parent::setTime($this->hour, $this->minute, $value);
                break;
            case 'timestamp':
                parent::setTimestamp($value);
                break;
            case 'timezone':
            case 'tz':
                $this->setTimezone($value);
                break;
            default:
                throw new InvalidArgumentException(sprintf('Unknown setter \'%s\'', $name));
        }
    }
    public function year($value)
    {
        $this->year = $value;
        return $this;
    }
    public function month($value)
    {
        $this->month = $value;
        return $this;
    }
    public function day($value)
    {
        $this->day = $value;
        return $this;
    }
    public function setDate($year, $month, $day)
    {
        parent::setDate($year, $month, $day);
        return $this;
    }
    public function hour($value)
    {
        $this->hour = $value;
        return $this;
    }
    public function minute($value)
    {
        $this->minute = $value;
        return $this;
    }
    public function second($value)
    {
        $this->second = $value;
        return $this;
    }
    public function setTime($hour, $minute, $second = 0)
    {
        parent::setTime($hour, $minute, $second);
        return $this;
    }
    public function setDateTime($year, $month, $day, $hour, $minute, $second = 0)
    {
        return $this->setDate($year, $month, $day)->setTime($hour, $minute, $second);
    }
    public function timestamp($value)
    {
        $this->timestamp = $value;
        return $this;
    }
    public function timezone($value)
    {
        return $this->setTimezone($value);
    }
    public function tz($value)
    {
        return $this->setTimezone($value);
    }
    public function setTimezone($value)
    {
        parent::setTimezone(static::safeCreateDateTimeZone($value));
        return $this;
    }
    public static function setTestNow(Carbon $testNow = null)
    {
        static::$testNow = $testNow;
    }
    public static function getTestNow()
    {
        return static::$testNow;
    }
    public static function hasTestNow()
    {
        return static::getTestNow() !== null;
    }
    public static function hasRelativeKeywords($time)
    {
        if (preg_match('/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/', $time) !== 1) {
            foreach (static::$relativeKeywords as $keyword) {
                if (stripos($time, $keyword) !== false) {
                    return true;
                }
            }
        }
        return false;
    }
    public function formatLocalized($format)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $format = preg_replace('#(?<!%)((?:%%)*)%e#', '\\1%#d', $format);
        }
        return strftime($format, $this->timestamp);
    }
    public static function resetToStringFormat()
    {
        static::setToStringFormat(self::DEFAULT_TO_STRING_FORMAT);
    }
    public static function setToStringFormat($format)
    {
        static::$toStringFormat = $format;
    }
    public function __toString()
    {
        return $this->format(static::$toStringFormat);
    }
    public function toDateString()
    {
        return $this->format('Y-m-d');
    }
    public function toFormattedDateString()
    {
        return $this->format('M j, Y');
    }
    public function toTimeString()
    {
        return $this->format('H:i:s');
    }
    public function toDateTimeString()
    {
        return $this->format('Y-m-d H:i:s');
    }
    public function toDayDateTimeString()
    {
        return $this->format('D, M j, Y g:i A');
    }
    public function toAtomString()
    {
        return $this->format(self::ATOM);
    }
    public function toCookieString()
    {
        return $this->format(self::COOKIE);
    }
    public function toIso8601String()
    {
        return $this->format(self::ISO8601);
    }
    public function toRfc822String()
    {
        return $this->format(self::RFC822);
    }
    public function toRfc850String()
    {
        return $this->format(self::RFC850);
    }
    public function toRfc1036String()
    {
        return $this->format(self::RFC1036);
    }
    public function toRfc1123String()
    {
        return $this->format(self::RFC1123);
    }
    public function toRfc2822String()
    {
        return $this->format(self::RFC2822);
    }
    public function toRfc3339String()
    {
        return $this->format(self::RFC3339);
    }
    public function toRssString()
    {
        return $this->format(self::RSS);
    }
    public function toW3cString()
    {
        return $this->format(self::W3C);
    }
    public function eq(Carbon $dt)
    {
        return $this == $dt;
    }
    public function ne(Carbon $dt)
    {
        return !$this->eq($dt);
    }
    public function gt(Carbon $dt)
    {
        return $this > $dt;
    }
    public function gte(Carbon $dt)
    {
        return $this >= $dt;
    }
    public function lt(Carbon $dt)
    {
        return $this < $dt;
    }
    public function lte(Carbon $dt)
    {
        return $this <= $dt;
    }
    public function between(Carbon $dt1, Carbon $dt2, $equal = true)
    {
        if ($dt1->gt($dt2)) {
            $temp = $dt1;
            $dt1 = $dt2;
            $dt2 = $temp;
        }
        if ($equal) {
            return $this->gte($dt1) && $this->lte($dt2);
        } else {
            return $this->gt($dt1) && $this->lt($dt2);
        }
    }
    public function min(Carbon $dt = null)
    {
        $dt = $dt === null ? static::now($this->tz) : $dt;
        return $this->lt($dt) ? $this : $dt;
    }
    public function max(Carbon $dt = null)
    {
        $dt = $dt === null ? static::now($this->tz) : $dt;
        return $this->gt($dt) ? $this : $dt;
    }
    public function isWeekday()
    {
        return $this->dayOfWeek != self::SUNDAY && $this->dayOfWeek != self::SATURDAY;
    }
    public function isWeekend()
    {
        return !$this->isWeekDay();
    }
    public function isYesterday()
    {
        return $this->toDateString() === static::yesterday($this->tz)->toDateString();
    }
    public function isToday()
    {
        return $this->toDateString() === static::now($this->tz)->toDateString();
    }
    public function isTomorrow()
    {
        return $this->toDateString() === static::tomorrow($this->tz)->toDateString();
    }
    public function isFuture()
    {
        return $this->gt(static::now($this->tz));
    }
    public function isPast()
    {
        return $this->lt(static::now($this->tz));
    }
    public function isLeapYear()
    {
        return $this->format('L') == '1';
    }
    public function isSameDay(Carbon $dt)
    {
        return $this->toDateString() === $dt->toDateString();
    }
    public function addYears($value)
    {
        return $this->modify((int) $value . ' year');
    }
    public function addYear()
    {
        return $this->addYears(1);
    }
    public function subYear()
    {
        return $this->addYears(-1);
    }
    public function subYears($value)
    {
        return $this->addYears(-1 * $value);
    }
    public function addMonths($value)
    {
        return $this->modify((int) $value . ' month');
    }
    public function addMonth()
    {
        return $this->addMonths(1);
    }
    public function subMonth()
    {
        return $this->addMonths(-1);
    }
    public function subMonths($value)
    {
        return $this->addMonths(-1 * $value);
    }
    public function addDays($value)
    {
        return $this->modify((int) $value . ' day');
    }
    public function addDay()
    {
        return $this->addDays(1);
    }
    public function subDay()
    {
        return $this->addDays(-1);
    }
    public function subDays($value)
    {
        return $this->addDays(-1 * $value);
    }
    public function addWeekdays($value)
    {
        return $this->modify((int) $value . ' weekday');
    }
    public function addWeekday()
    {
        return $this->addWeekdays(1);
    }
    public function subWeekday()
    {
        return $this->addWeekdays(-1);
    }
    public function subWeekdays($value)
    {
        return $this->addWeekdays(-1 * $value);
    }
    public function addWeeks($value)
    {
        return $this->modify((int) $value . ' week');
    }
    public function addWeek()
    {
        return $this->addWeeks(1);
    }
    public function subWeek()
    {
        return $this->addWeeks(-1);
    }
    public function subWeeks($value)
    {
        return $this->addWeeks(-1 * $value);
    }
    public function addHours($value)
    {
        return $this->modify((int) $value . ' hour');
    }
    public function addHour()
    {
        return $this->addHours(1);
    }
    public function subHour()
    {
        return $this->addHours(-1);
    }
    public function subHours($value)
    {
        return $this->addHours(-1 * $value);
    }
    public function addMinutes($value)
    {
        return $this->modify((int) $value . ' minute');
    }
    public function addMinute()
    {
        return $this->addMinutes(1);
    }
    public function subMinute()
    {
        return $this->addMinutes(-1);
    }
    public function subMinutes($value)
    {
        return $this->addMinutes(-1 * $value);
    }
    public function addSeconds($value)
    {
        return $this->modify((int) $value . ' second');
    }
    public function addSecond()
    {
        return $this->addSeconds(1);
    }
    public function subSecond()
    {
        return $this->addSeconds(-1);
    }
    public function subSeconds($value)
    {
        return $this->addSeconds(-1 * $value);
    }
    public function diffInYears(Carbon $dt = null, $abs = true)
    {
        $dt = $dt === null ? static::now($this->tz) : $dt;
        return (int) $this->diff($dt, $abs)->format('%r%y');
    }
    public function diffInMonths(Carbon $dt = null, $abs = true)
    {
        $dt = $dt === null ? static::now($this->tz) : $dt;
        return $this->diffInYears($dt, $abs) * self::MONTHS_PER_YEAR + $this->diff($dt, $abs)->format('%r%m');
    }
    public function diffInWeeks(Carbon $dt = null, $abs = true)
    {
        return (int) ($this->diffInDays($dt, $abs) / self::DAYS_PER_WEEK);
    }
    public function diffInDays(Carbon $dt = null, $abs = true)
    {
        $dt = $dt === null ? static::now($this->tz) : $dt;
        return (int) $this->diff($dt, $abs)->format('%r%a');
    }
    public function diffInDaysFiltered(Closure $callback, Carbon $dt = null, $abs = true)
    {
        $start = $this;
        $end = $dt === null ? static::now($this->tz) : $dt;
        $inverse = false;
        if ($end < $start) {
            $start = $end;
            $end = $this;
            $inverse = true;
        }
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $days = array_filter(iterator_to_array($period), function (DateTime $date) use($callback) {
            return call_user_func($callback, Carbon::instance($date));
        });
        $diff = count($days);
        return $inverse && !$abs ? -$diff : $diff;
    }
    public function diffInWeekdays(Carbon $dt = null, $abs = true)
    {
        return $this->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, $dt, $abs);
    }
    public function diffInWeekendDays(Carbon $dt = null, $abs = true)
    {
        return $this->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekend();
        }, $dt, $abs);
    }
    public function diffInHours(Carbon $dt = null, $abs = true)
    {
        return (int) ($this->diffInSeconds($dt, $abs) / self::SECONDS_PER_MINUTE / self::MINUTES_PER_HOUR);
    }
    public function diffInMinutes(Carbon $dt = null, $abs = true)
    {
        return (int) ($this->diffInSeconds($dt, $abs) / self::SECONDS_PER_MINUTE);
    }
    public function diffInSeconds(Carbon $dt = null, $abs = true)
    {
        $value = ($dt === null ? time() : $dt->getTimestamp()) - $this->getTimestamp();
        return $abs ? abs($value) : $value;
    }
    public function diffForHumans(Carbon $other = null)
    {
        $isNow = $other === null;
        if ($isNow) {
            $other = static::now($this->tz);
        }
        $isFuture = $this->gt($other);
        $delta = $other->diffInSeconds($this);
        $divs = array('second' => self::SECONDS_PER_MINUTE, 'minute' => self::MINUTES_PER_HOUR, 'hour' => self::HOURS_PER_DAY, 'day' => self::DAYS_PER_WEEK, 'week' => 30 / self::DAYS_PER_WEEK, 'month' => self::MONTHS_PER_YEAR);
        $unit = 'year';
        foreach ($divs as $divUnit => $divValue) {
            if ($delta < $divValue) {
                $unit = $divUnit;
                break;
            }
            $delta = $delta / $divValue;
        }
        $delta = (int) $delta;
        if ($delta == 0) {
            $delta = 1;
        }
        $txt = $delta . ' ' . $unit;
        $txt .= $delta == 1 ? '' : 's';
        if ($isNow) {
            if ($isFuture) {
                return $txt . ' from now';
            }
            return $txt . ' ago';
        }
        if ($isFuture) {
            return $txt . ' after';
        }
        return $txt . ' before';
    }
    public function startOfDay()
    {
        return $this->hour(0)->minute(0)->second(0);
    }
    public function endOfDay()
    {
        return $this->hour(23)->minute(59)->second(59);
    }
    public function startOfMonth()
    {
        return $this->startOfDay()->day(1);
    }
    public function endOfMonth()
    {
        return $this->day($this->daysInMonth)->endOfDay();
    }
    public function startOfYear()
    {
        return $this->month(1)->startOfMonth();
    }
    public function endOfYear()
    {
        return $this->month(self::MONTHS_PER_YEAR)->endOfMonth();
    }
    public function startOfDecade()
    {
        return $this->startOfYear()->year($this->year - $this->year % self::YEARS_PER_DECADE);
    }
    public function endOfDecade()
    {
        return $this->endOfYear()->year($this->year - $this->year % self::YEARS_PER_DECADE + self::YEARS_PER_DECADE - 1);
    }
    public function startOfCentury()
    {
        return $this->startOfYear()->year($this->year - $this->year % self::YEARS_PER_CENTURY);
    }
    public function endOfCentury()
    {
        return $this->endOfYear()->year($this->year - $this->year % self::YEARS_PER_CENTURY + self::YEARS_PER_CENTURY - 1);
    }
    public function startOfWeek()
    {
        if ($this->dayOfWeek != self::MONDAY) {
            $this->previous(self::MONDAY);
        }
        return $this->startOfDay();
    }
    public function endOfWeek()
    {
        if ($this->dayOfWeek != self::SUNDAY) {
            $this->next(self::SUNDAY);
        }
        return $this->endOfDay();
    }
    public function next($dayOfWeek = null)
    {
        if ($dayOfWeek === null) {
            $dayOfWeek = $this->dayOfWeek;
        }
        return $this->startOfDay()->modify('next ' . self::$days[$dayOfWeek]);
    }
    public function previous($dayOfWeek = null)
    {
        if ($dayOfWeek === null) {
            $dayOfWeek = $this->dayOfWeek;
        }
        return $this->startOfDay()->modify('last ' . self::$days[$dayOfWeek]);
    }
    public function firstOfMonth($dayOfWeek = null)
    {
        $this->startOfDay();
        if ($dayOfWeek === null) {
            return $this->day(1);
        }
        return $this->modify('first ' . self::$days[$dayOfWeek] . ' of ' . $this->format('F') . ' ' . $this->year);
    }
    public function lastOfMonth($dayOfWeek = null)
    {
        $this->startOfDay();
        if ($dayOfWeek === null) {
            return $this->day($this->daysInMonth);
        }
        return $this->modify('last ' . self::$days[$dayOfWeek] . ' of ' . $this->format('F') . ' ' . $this->year);
    }
    public function nthOfMonth($nth, $dayOfWeek)
    {
        $dt = $this->copy()->firstOfMonth();
        $check = $dt->format('Y-m');
        $dt->modify('+' . $nth . ' ' . self::$days[$dayOfWeek]);
        return $dt->format('Y-m') === $check ? $this->modify($dt) : false;
    }
    public function firstOfQuarter($dayOfWeek = null)
    {
        return $this->day(1)->month($this->quarter * 3 - 2)->firstOfMonth($dayOfWeek);
    }
    public function lastOfQuarter($dayOfWeek = null)
    {
        return $this->day(1)->month($this->quarter * 3)->lastOfMonth($dayOfWeek);
    }
    public function nthOfQuarter($nth, $dayOfWeek)
    {
        $dt = $this->copy()->day(1)->month($this->quarter * 3);
        $last_month = $dt->month;
        $year = $dt->year;
        $dt->firstOfQuarter()->modify('+' . $nth . ' ' . self::$days[$dayOfWeek]);
        return $last_month < $dt->month || $year !== $dt->year ? false : $this->modify($dt);
    }
    public function firstOfYear($dayOfWeek = null)
    {
        return $this->month(1)->firstOfMonth($dayOfWeek);
    }
    public function lastOfYear($dayOfWeek = null)
    {
        return $this->month(self::MONTHS_PER_YEAR)->lastOfMonth($dayOfWeek);
    }
    public function nthOfYear($nth, $dayOfWeek)
    {
        $dt = $this->copy()->firstOfYear()->modify('+' . $nth . ' ' . self::$days[$dayOfWeek]);
        return $this->year == $dt->year ? $this->modify($dt) : false;
    }
    public function average(Carbon $dt = null)
    {
        $dt = $dt === null ? static::now($this->tz) : $dt;
        return $this->addSeconds((int) ($this->diffInSeconds($dt, false) / 2));
    }
}
