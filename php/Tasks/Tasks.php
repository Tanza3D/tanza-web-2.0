<?php

namespace Tasks;

class Tasks
{
    public static function RunSpecific($name)
    {
        $classNamespace = '\\Tasks\\' . $name;

        if (class_exists($classNamespace)) {
            $instance = new $classNamespace();
            if (method_exists($instance, 'run')) {
                $instance->run();
            } else {
                throw new \Exception("Method 'run' not found in class $classNamespace");
            }
        } else {
            throw new \Exception("Class $classNamespace not found");
        }
    }
}
