<?php

namespace Floodx92\KhGateway\Trait;

trait Fillable
{
    public function fill(array $data): self
    {
        foreach ($data as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            if (!property_exists($this, $key)) {
                continue;
            }

            // is the property is an object of Fillable trait
            if (is_object($this->{$key}) && method_exists($this->{$key}, 'fill')) {
                $this->{$key}->fill($value);
                continue;
            }

            // if property is enum and value is string
            if (is_object($this->{$key}) && is_string($value) && method_exists($this->{$key}, 'from')) {
                $this->{$key} = $this->{$key}::from($value);
                continue;
            }

            $this->{$key} = $value;
        }

        return $this;
    }

    public static function fromArray(array $data): self
    {
        return (new self())->fill($data);
    }

    public function toArray(bool $filter = true): array
    {
        $array = get_object_vars($this);

        foreach ($array as $key => $value) {
            if (is_object($value) && method_exists($value, 'toArray')) {
                $array[$key] = $value->toArray($filter);
            }
        }

        if (!$filter) {
            return $array;
        }

        return array_filter($array, fn ($value) => null !== $value);
    }
}
