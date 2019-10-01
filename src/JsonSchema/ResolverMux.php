<?php

namespace Swaggest\JsonCli\JsonSchema;

use Swaggest\JsonSchema\RemoteRefProvider;

class ResolverMux implements RemoteRefProvider
{
    /** @var RemoteRefProvider[] */
    public $resolvers;

    public function getSchemaData($url)
    {
        foreach ($this->resolvers as $resolver) {
            $data = $resolver->getSchemaData($url);
            if (false !== $data) {
                return $data;
            }
        }

        return false;
    }
}