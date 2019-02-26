<?php declare(strict_types=1);

namespace Dbl;

class Collection implements
    \ArrayAccess,
    \IteratorAggregate,
    \Countable,
    \Serializable,
    \JsonSerializable
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param array $data
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->data = $data;
        }
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return serialize($this->data);
    }

    /**
     * @param string $data
     *
     * @return void
     */
    public function unserialize($data)
    {
        $this->data = unserialize($data);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }

    /**
     * @param mixed $offset
     */
    public function __get($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function __set($offset, $value): void
    {
        $this->data[$offset] = $value;
    }

    /**
     * @param callable $callback
     *
     * @return Collection
     */
    public function filter(callable $callback): Collection
    {
        $result = [];

        foreach ($this->data as $key => $value) {
            if ($callback($key, $value)) {
                $result[$key] = $value;
            }
        }

        return new Collection($result);
    }

    /**
     * @param callable $callback
     *
     * @return Collection
     */
    public function map(callable $callback): Collection
    {
        $result = [];

        foreach ($this->data as $key => $value) {
            $return = $callback($key, $value);

            if (is_array($return)) {
                list($k, $v) = $return;
                $result[$k] = $v;
            } else {
                $result[$key] = $return;
            }
        }

        return new Collection($result);
    }

    /**
     * @return array
     */
    public function raw(): array
    {
        return $this->data;
    }
}