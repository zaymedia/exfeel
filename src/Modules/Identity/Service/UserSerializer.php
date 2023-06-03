<?php

declare(strict_types=1);

namespace App\Modules\Identity\Service;

class UserSerializer
{
    public function serialize(array $user): array
    {
        return [
            'id' => $user['id'],
        ];
    }

    public function serializeItems(array $items): array
    {
        $result = [];

        /** @var array $item */
        foreach ($items as $item) {
            $result[] = $this->serialize($item);
        }

        return $result;
    }
}
