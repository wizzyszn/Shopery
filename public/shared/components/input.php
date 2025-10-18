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
            <div class="password-field-wrapper">
                <input ' . $attrs . ' />
                <svg onclick="changePasswordVisibility(this)" class="show-password" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                <svg onclick="changePasswordVisibility(this)" class="hide-password hidden" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z"/></svg>
            </div>
            <script> 
            function changePasswordVisibility(icon) {
                const container = icon.closest(".password-field-wrapper");
                const input = container.querySelector("input");
                const showIcon = container.querySelector(".show-password");
                const hideIcon = container.querySelector(".hide-password");
                
                if (input.type === "password") {
                    input.type = "text";
                    showIcon.classList.add("hidden");
                    hideIcon.classList.remove("hidden");
                } else {
                    input.type = "password";
                    showIcon.classList.remove("hidden");
                    hideIcon.classList.add("hidden");
                }
            }
            </script>
            ';
        }
        return "<input {$attrs} />";
    }
}
