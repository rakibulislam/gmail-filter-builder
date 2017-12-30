<?php

namespace Opdavies\GmailFilterBuilder;

class Builder
{
    private $filters = [];

    public function __construct(array $filters) {
        $this->filters = $filters;
    }

    public function build()
    {
        $prefix = "<?xml version='1.0' encoding='UTF-8'?><feed xmlns='http://www.w3.org/2005/Atom' xmlns:apps='http://schemas.google.com/apps/2006'>";
        $suffix = '</feed>';

        $xml = collect($this->filters)->map(function ($items) {
            return $this->buildEntry($items);
        })->implode('');

        return $prefix . $xml . $suffix;
    }

    /**
     * @param array $items
     *
     * @return string
     */
    private function buildEntry(array $items)
    {
        $entry = collect($items)->map(function ($value, $key) {
            return $this->buildProperty($value, $key);
        })->implode('');

        return "<entry>{$entry}</entry>";
    }

    /**
     * Build XML for a property.
     *
     * @param string $value
     * @param string $key
     *
     * @return string
     */
    private function buildProperty($value, $key)
    {
        if ($key == 'from') {
            $value = collect($value)->implode('|');
        }

        return "<apps:property name='{$key}' value='{$value}'/>";
    }
}
