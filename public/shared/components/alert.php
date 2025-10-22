<?php

class Alert 
{
    private $type;
    private $content;
    private $attributes;


    public function __construct($type = "success", $content = "", $attributes = [])
    {
        $this->type = $this->setType($type);
        $this->attributes = $attributes;
        $this->content = $this->setContent($content);
    }


    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function render()
    {
        return "";
    }
}
