<?php

namespace Dlabs\PaginateApi;

use ArrayAccess;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use IteratorAggregate;
use JsonSerializable;

/**
 *  * Author: Oluwatobi Adenekan
 * Date: 12/04/2020
 * Time: 4:37 PM
 */
class PaginateApiAwarePaginator extends AbstractPaginator
    implements
    Arrayable,
    ArrayAccess,
    Countable,
    IteratorAggregate,
    Jsonable,
    JsonSerializable
{


    /**
     * @var bool
     */
    private $hasMore;
    /**
     * @var int|null
     */
    private $total;
    /**
     * @var int
     */
    private $offset;
    /**
     * @var array|Request|string
     */
    private $request;

    public function __construct($items, $perPage = 20, $total = null, $offset = 0, array $options = [])
    {
        foreach ($options as $key => $value) {
            $this->{$key} = $value;
        }

        $this->perPage = $perPage;

        if (is_null($this->request)) {
            $this->request = request();
        }

        $this->offset = $this->request->offset ?? $offset;

        $this->query = $this->getRawQuery();

        $this->setItems($items);

        $this->total = $total ?? $this->items->count();
    }

    public function toArray()
    {
        {
            return [
                'data' => $this->items->toArray(),
                'offset' => $this->getOffset(),
                'limit' => $this->perPage(),
                'count' => $this->count(),
            ];
        }
    }


    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    private function setItems($items)
    {
        $this->items = $items instanceof Collection ? $items : Collection::make($items);

        $this->hasMore = $this->items->count() > $this->perPage;

        $this->items = $this->items->slice(0, $this->perPage);
    }

    protected function getRawQuery()
    {
        return collect($this->request->query())
            ->diffKeys([
                'offset' => true,
            ])->all();
    }

    public function nextOffset()
    {
        return $this->total - $this->perPage > $this->offset ? $this->offset + $this->perPage : null;
    }

    /**
     * @return string|null
     */
    public function prevOffset()
    {
        if ($this->offset >= $this->perPage) {
            return $this->offset - $this->perPage;
        }
    }


    public function getOffset()
    {
        return intval($this->offset);
    }


    public function count()
    {
        return $this->total;
    }

    public function result()
    {
        return $this->items();
    }


}
