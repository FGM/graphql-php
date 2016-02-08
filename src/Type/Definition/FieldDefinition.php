<?php

namespace Fubhy\GraphQL\Type\Definition;

class FieldDefinition
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $description;

    /**
     * @var \Fubhy\GraphQL\Type\Definition\Types\OutputTypeInterface|callable
     */
    protected $type;

    /**
     * @var array
     */
    protected $args = [];

    /**
     * @var string|null
     */
    protected $deprecationReason;

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->name = $config['name'];
        $this->type = $config['type'];
        $this->description = isset($config['description']) ? $config['description'] : NULL;
        $this->resolve = isset($config['resolve']) ? $config['resolve'] : NULL;

        if (isset($config['args'])) {
            $this->args = $config['args'];
        }

        if (isset($config['deprecationReason'])) {
            $this->deprecationReason = $config['deprecationReason'];
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return \Fubhy\GraphQL\Type\Definition\Types\OutputTypeInterface
     */
    public function getType()
    {
        if (is_callable($this->type)) {
            return call_user_func($this->type);
        }

        return $this->type;
    }

    /**
     * @return callable|null
     */
    public function getResolveCallback()
    {
        return $this->resolve;
    }

    /**
     * @return string|null
     */
    public function getDeprecationReason()
    {
        return $this->deprecationReason;
    }

    /**
     * @return \Fubhy\GraphQL\Type\Definition\FieldArgument[]
     */
    public function getArguments()
    {
        if (!isset($this->argMap)) {
            $this->argMap = [];
            foreach ($this->args as $name => $arg) {
                if (!isset($arg['name'])) {
                    $arg['name'] = $name;
                }

                $this->argMap[$name] = new FieldArgument($arg);
            }
        }

        return $this->argMap;
    }
}