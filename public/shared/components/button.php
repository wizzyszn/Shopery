<?php

class Button
{
    private $text;
    private $type;
    private $attributes;

    private const VALID_TYPES = ["primary", "secondary", "success", "danger", "warninig"];
    private const TYPE_CLASS_MAP = [
        "primary" => "btn-primary",
        "success" => "btn-success",
        "danger" => "btn-danger",
        "warning" => "btn-warning",
        "secondary" => "btn-secondary"
    ];
    public function __construct($text, $type = "primary", $attributes = [])
    {
        $this->setText($text);
        $this->setType($type);
        $this->attributes = $attributes;
    }

    public function setType($type)
    {
        $type = strtolower($type);
        if (!in_array($type, self::VALID_TYPES)) {
            throw new InvalidArgumentException("Invalid button type: {$type}. Valid types: " . implode(", ", self::VALID_TYPES));
        }
        $this->type = $type;
        return $this;
    }
    public function setText($text)
    {
        if (empty(trim($text))) {
            throw new InvalidArgumentException("Button text cannot be empty");
        }
        $this->text = $text;
        return $this;
    }
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function render()
    {
        $class = 'btn ' . self::TYPE_CLASS_MAP[$this->type];
        if (isset($this->attributes['class'])) {
            $class .= ' ' . $this->attributes['class'];
            unset($this->attributes['class']);
        }
        $attrs = $this->buildAttributes(["class" => $class]);

        return "<button {$attrs}>{$this->text}</button>";
    }

    private function buildAttributes($attributes)
    {
        $attributes = array_merge($attributes, $this->attributes);
        $parts = [];

        foreach ($attributes as $key => $value) {
            $key = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            $parts[] = "{$key}=\"{$value}\"";
        }
        return $parts ? ' ' . implode(' ', $parts) : '';
    }
}
