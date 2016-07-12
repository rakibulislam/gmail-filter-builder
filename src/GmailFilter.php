<?php

class GmailFilter
{
    /**
     * @param array
     */
    private $conditions = [];

    /**
     * @param array
     */
    private $labels = [];

    private $archive = false;

    private $spam = false;

    private $trash = false;

    /**
     * @return boolean
     */
    public function isTrash() {
        return $this->trash;
    }

    private $neverSpam = false;

    /**
     * @return mixed
     */
    public function getConditions() {
        return $this->conditions;
    }

    /**
     * @return mixed
     */
    public function getLabels() {
        return $this->labels;
    }

    /**
     * @return boolean
     */
    public function isArchive() {
        return $this->archive;
    }

    /**
     * @return boolean
     */
    public function isSpam() {
        return $this->spam;
    }

    /**
     * @return boolean
     */
    public function isNeverSpam() {
        return $this->neverSpam;
    }

    public function __get($name) {
        return $this->$name;
    }

    public static function create()
    {
        return new static();
    }

    public function contains($value) {
        return $this->condition('hasTheWord', $value);
    }

    public function subject($value) {
        return $this->condition('subject', $value);
    }

    /**
     * Add a label.
     *
     * @param string $label
     *   The label to assign.
     *
     * @return $this
     */
    public function label($label) {
        $this->labels[] = $label;

        return $this;
    }

    /**
     * @return $this
     */
    public function archive() {
        $this->archive = true;

        return $this;
    }

    /**
     * Mark as spam.
     *
     * @return $this
     */
    public function spam() {
        $this->spam = true;
        $this->neverSpam = false;

        return $this;
    }

    /**
     * Never mark as spam.
     *
     * @return $this
     */
    public function neverSpam() {
        $this->neverSpam = true;
        $this->spam = false;

        return $this;
    }

    /**
     * Who the email is from.
     *
     * @param array $values
     *   An array of names or email addresses for the sender.
     *
     * @return $this
     */
    public function from(array $values)
    {
        $this->condition('from', implode('||', $values));

        return $this;
    }

    /**
     * Who the email is sent to.
     *
     * @param array $values
     *   An array of names or email addresses for the receiver.
     *
     * @return $this
     */
    public function to(array $values)
    {
        $this->condition('to', implode('||', $values));

        return $this;
    }

    /**
     * Add a condition.
     *
     * @param string $type
     *   The type of condition.
     * @param $value
     *   The value of the condition.
     *
     * @return $this
     */
    private function condition($type, $value)
    {
        $this->conditions[] = [$type, $value];

        return $this;
    }
}