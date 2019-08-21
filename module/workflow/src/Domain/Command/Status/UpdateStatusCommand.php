<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See license.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Workflow\Domain\Command\Status;

use Ergonode\Workflow\Domain\Entity\WorkflowId;
use Ergonode\Workflow\Domain\ValueObject\Status;
use JMS\Serializer\Annotation as JMS;

/**
 */
class UpdateStatusCommand
{
    /**
     * @var WorkflowId
     *
     * @JMS\Type("Ergonode\Workflow\Domain\Entity\WorkflowId")
     */
    private $id;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $code;

    /**
     * @var Status
     *
     * @JMS\Type("Ergonode\Workflow\Domain\ValueObject\Status")
     */
    private $status;

    /**
     * @param WorkflowId $id
     * @param string     $code
     * @param Status     $status
     */
    public function __construct(WorkflowId $id, string $code, Status $status)
    {
        $this->id = $id;
        $this->code = $code;
        $this->status = $status;
    }

    /**
     * @return WorkflowId
     */
    public function getId(): WorkflowId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }
}