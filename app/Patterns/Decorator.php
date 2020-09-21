<?php

namespace App\Pattern;


class BasicAttack implements Component
{
    public function operation()
    {
        return "Attack";
    }
}


class Decorator implements Component
{
    /**
     * @var Component
     */
    protected $component;

    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    public function operation()
    {
        return $this->component->operation();
    }
}


class SkillNumberOne extends Decorator
{
    public function operation()
    {
        return "SkillNumberOne + " . parent::operation();
    }
}

class SkillNumberTwo extends Decorator
{
    public function operation()
    {
        return "SkillNumberTwo + " . parent::operation();
    }
}

class SkillNumberThree extends Decorator
{
    public function operation()
    {
        return "SkillNumberThree + " . parent::operation();
    }
}


class SkillNumberFour extends Decorator
{
    public function operation()
    {
        return "SkillNumberFour + " . parent::operation();
    }
}

function clientCode(Component $component)
{
    echo "RESULT: " . $component->operation();
}

?>