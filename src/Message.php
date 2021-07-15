<?php

namespace Nubix\Toast;

class Message
{
    public ?string $id;

    public ?string $title;

    public string $body = '';

    public string $type = 'info';

    public ?int $timeout = null;

    public bool $important = false;

    /**
     * Message constructor.
     * @param string|array $attributes
     */
    public function __construct(string|array $attributes)
    {
        if (is_array($attributes)) {
            $this->update($attributes);
        } else {
            $this->body = $attributes;
        }

        if(!isset($this->timeout)){
            $this->timeout  = config('toast.timeout');
        }
    }

    /**
     * Update the attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function update(array $attributes = [])
    {
        $attributes = array_filter($attributes);

        foreach ($attributes as $key => $attribute) {
            $this->$key = $attribute;
        }

        return $this;
    }
}
