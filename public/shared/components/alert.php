<?php

class Alert
{
    private $type;
    private $content;
    private $attributes;
    private $allowHtml; // security check to decide if html is should be escaped or rendered as is

    public function __construct($type = "success", $content = "", $attributes = [])
    {
        $this->type = $type;
        $this->content = $content;
        $this->attributes = $attributes;
        $this->allowHtml = false;
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

    public function setAllowHtml($allow = true)
    {
        $this->allowHtml = $allow;
        return $this;
    }

    private function buildAttributes()
    {
        if (empty($this->attributes)) {
            return '';
        }

        $attrString = '';
        foreach ($this->attributes as $key => $value) {
            $attrString .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($value) . '"';
        }
        return $attrString;
    }

    public function render()
    {
        $attributes = $this->buildAttributes();
        $alertClass = 'alert alert-' . htmlspecialchars($this->type);

        $html = "<div class='{$alertClass}'{$attributes}>";
        $html .= $this->allowHtml ? $this->content : htmlspecialchars($this->content);
        $html .= "</div>";

        return $html;
    }
}
