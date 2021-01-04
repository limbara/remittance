<?php

namespace App\Services\Api;

use App\Exceptions\Api\NotFoundException;
use App\Models\Relationship;

class RelationshipService
{
  /**
   * @param string $relationshipId
   * @return Relationship
   * @throws NotFoundException
   */
  public function find(string $relationshipId): Relationship
  {
    $relationship = Relationship::find($relationshipId);

    if (!$relationship) {
      throw new NotFoundException('Relationship Not Found');
    }

    return $relationship;
  }
}
