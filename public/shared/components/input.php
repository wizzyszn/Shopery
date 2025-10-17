<?php

class Input
{

    private $type;
    private $attributes;
    private $value;
    private $name;
    private const VALID_INPUT_TYPES = [
        "text",
        "email",
        "button",
        "file",
        "password",
        "number",
        "tel",
        "url",
        "date",
        "checkbox",
        "radio"
    ];
    public function __construct($type = "text", $attributes = [])
    {
        $this->setType($type);
        $this->attributes = $attributes;
        $this->value = '';
    }


    public function setType($type)
    {
        $type = strtolower($type);
        if (!in_array($type, self::VALID_INPUT_TYPES)) {
            throw new InvalidArgumentException("Invalid input type: {$type}. Valid types: " . implode(", ", self::VALID_INPUT_TYPES));
        }
        $this->type = $type;
        return $this;
    }
    public function setName($name)
    {
        $this->attributes["name"] = $name;
        return $this;
    }
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function setPlaceHolder($placeholder)
    {
        $this->attributes['placeholder'] = $placeholder;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function setRequired($required = true)
    {
        if ($required) {
            $this->attributes['required'] = $required;
        } else {
            unset($this->attributes['required']);
        }
        return $this;
    }

    public function setDisabled($disabled = true)
    {
        if ($disabled) {
            $this->attributes['disabled'];
        } else {
            unset($this->attributes['disabled']);
        }

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }
    private function buildAttributes($attributes)
    {
        $parts = [];
        $attributes = array_merge($this->attributes, $attributes);
        foreach ($attributes as $key => $value) {
            $key = htmlspecialchars($key, ENT_QUOTES, "UTF-8");
            $value = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
            $parts[] = "{$key}=\"{$value}\"";
        }
        return $parts ? ' ' . implode(' ', $parts) : "";
    }
    public function render()
    {
        $class = "inpt";
        if (isset($this->attributes["class"])) {
            $class .= ' ' . $this->attributes["class"];
            unset($this->attributes['class']);
        }
        $baseAttributes = [
            "type" => $this->type,
            "class" => $class
        ];
        if (!$this->value = "" && $this->type !== "file") {
            $baseAttributes["value"] = $this->value;
        }
        $attrs = $this->buildAttributes($baseAttributes);
        if ($this->type == "password") {
            return '
            <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
<path d="M1.66675 10.5003C1.66675 10.5003 4.69675 4.66699 10.0001 4.66699C15.3034 4.66699 18.3334 10.5003 18.3334 10.5003C18.3334 10.5003 15.3034 16.3337 10.0001 16.3337C4.69675 16.3337 1.66675 10.5003 1.66675 10.5003Z" stroke="#1A1A1A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10 13C10.663 13 11.2989 12.7366 11.7678 12.2678C12.2366 11.7989 12.5 11.163 12.5 10.5C12.5 9.83696 12.2366 9.20107 11.7678 8.73223C11.2989 8.26339 10.663 8 10 8C9.33696 8 8.70107 8.26339 8.23223 8.73223C7.76339 9.20107 7.5 9.83696 7.5 10.5C7.5 11.163 7.76339 11.7989 8.23223 12.2678C8.70107 12.7366 9.33696 13 10 13V13Z" stroke="#1A1A1A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>   
            <input />
            </div>';
        }
        return "<input {$attrs} />";
    }
}
