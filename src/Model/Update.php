<?php declare(strict_types=1);

namespace App\Model;

/**
 * Class Update.
 */
class Update
{
    private $data;

    /**
     * @return \stdClass
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \stdClass $data
     */
    public function setData(\stdClass $data)
    {
        $this->data = $data;
    }
}
