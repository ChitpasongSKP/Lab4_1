<?php


/**
 * @property int a
 */
class PropertyTest
{
/** Location for overloaded data */
    private $data = array();
    /** Overloading not used on declared properties */
    public $declare = 1;
    /** Overloading only used on this when accessed outside the class */
    public $hidden = 2;

    public function _set($name, $value) {
        echo "Setting '$name' to '$value'\n";
        $this->data[$name] = $value;
    }
    public function _get($name) {
        echo "Getting '$name'\n";
        if (arrey_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        $trace = debug_backtrace();
        trigger_error (
            'Undefined property via _get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    /** As of PHP 5.1.0
     * @param $name
     * @return bool
     */
    public function __isset($name) {
        echo "Is '$name' set?\n";
        return isset($this->data[$name]);
    }

    /** As of PHP 5.1.0
     */
    public function __unset($name) {
        echo "Unsetting '$name'\n";
        unset($this->data[$name]);
    }


    /** Not a magic method, just here for example. */
    public function getHidden() {
        return $this->hidden;
    }
}
echo "<pre>\n";
$obj = new PropertyTest;

$obj->a = 1;
echo $obj->a . "\n\n";

var_dump(isset($obj->a));
unset($obj->a);
var_dump(isset($obj->a));
echo"\n";

echo $obj->declared . "\n\n";

echo "Let's experiment with the private property name 'hidden' :\n";
echo "Privates are visible inside the class, so _get() not used...\n";
echo $obj->getHidden() . "\n";
echo "Privates not visible outside of class, so _get() is used...\n";
echo $obj->hidden . "\n";
?>