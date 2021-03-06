<?php
namespace kahlan\jit\patcher;

use kahlan\plugin\DummyClass as DummyClassPlugin;

class DummyClass {

    /**
     * Namespaces which allow auto mock on unexisting classes.
     *
     * @var array
     */
    protected $_namespaces = [];

    public function __construct($options = [])
    {
        $defaults = ['namespaces' => []];
        $options += $defaults;
        $this->_namespaces = (array) $options['namespaces'];
    }

    /**
     * The JIT find file patcher.
     *
     * @param  object $loader The autloader instance.
     * @param  string $class  The fully-namespaced class name.
     * @param  string $file   The correponding finded file path.
     * @return string         The patched file path.
     */
    public function findFile($loader, $class, $file)
    {
        if ($file) {
            return $file;
        }
        $allowed = empty($this->_namespaces);
        foreach ($this->_namespaces as $ns) {
            if (strpos($class, $ns) === 0) {
                $allowed = true;
            }
        }
        if (!DummyClassPlugin::enabled() || !$allowed) {
            return $file;
        }
        $classpath = strtr($class, '\\', DS);
        return $loader->cache('/dummies/' . $classpath . '.php', static::generate(compact('class')));
    }

    /**
     * The JIT patcher.
     *
     * @param  NodeDef $node The node to patch.
     * @param  string  $path The file path of the source code.
     * @return NodeDef       The patched node.
     */
    public function process($node, $path = null)
    {
        return $node;
    }

    /**
     * Create a Dummy Class.
     *
     * @param  string $namespace The namespace name.
     * @param  string $class     The class name.
     * @return string            The Dummy Class content.
     */
    public static function generate($options = [])
    {
        extract($options);

        if (($pos = strrpos($class, '\\')) !== false) {
            $namespace = substr($class, 0, $pos);
            $class = substr($class, $pos + 1);
        } else {
            $namespace = '';
        }

        if ($namespace) {
            $namespace = "namespace {$namespace};\n";
        }
return "<?php\n\n" . $namespace . <<<EOT

use kahlan\IncompleteException;

class {$class} {

    public function __construct() {
        throw new IncompleteException("PHP Fatal error: Class `{$class}` not found.");
    }

    public static function __callStatic(\$name, \$params) {
        throw new IncompleteException("PHP Fatal error: Class `{$class}` not found.");
    }
}

?>
EOT;

    }

    /**
     * The JIT backtrace patcher (make backtrace ignore inserted closure).
     *
     * @see kahlan\analysis\Debugger::normalize()
     *
     * @param  array $options   Format for outputting stack trace.
     * @param  array $backtrace The backtrace array.
     * @return array            The patched backtrace.
     */
    public function processBacktrace($options, $backtrace)
    {
        return $backtrace;
    }

}
