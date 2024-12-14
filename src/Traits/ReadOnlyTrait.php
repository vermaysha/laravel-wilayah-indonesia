<?php

namespace Vermaysha\Territory\Traits;

use Vermaysha\Territory\Exceptions\ReadOnlyModelException;

trait ReadOnlyTrait
{
    /**
     * Throw an exception on attempting to save the model.
     *
     *
     * @throws \Vermaysha\Territory\Exceptions\ReadOnlyModelException
     */
    public function save(array $options = [])
    {
        throw new ReadOnlyModelException('This model is read-only.');
    }

    /**
     * Throw an exception on attempting to delete the model.
     *
     * @throws \Vermaysha\Territory\Exceptions\ReadOnlyModelException
     */
    public function delete()
    {
        throw new ReadOnlyModelException('This model is read-only.');
    }

    /**
     * Throw an exception on attempting to update the model.
     *
     *
     * @throws \Vermaysha\Territory\Exceptions\ReadOnlyModelException
     */
    public function update(array $attributes = [], array $options = [])
    {
        throw new ReadOnlyModelException('This model is read-only.');
    }

    /**
     * Throw an exception on attempting to create the model.
     *
     *
     * @throws \Vermaysha\Territory\Exceptions\ReadOnlyModelException
     */
    public static function create(array $attributes = [])
    {
        throw new ReadOnlyModelException('This model is read-only.');
    }

    /**
     * Throw an exception on attempting to force delete the model.
     *
     * @throws \Vermaysha\Territory\Exceptions\ReadOnlyModelException
     */
    public function forceDelete()
    {
        throw new ReadOnlyModelException('This model is read-only.');
    }

    /**
     * Throw an exception on attempting to restore the model.
     *
     * @throws \Vermaysha\Territory\Exceptions\ReadOnlyModelException
     */
    public function restore()
    {
        throw new ReadOnlyModelException('This model is read-only.');
    }
}
