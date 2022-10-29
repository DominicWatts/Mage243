<?php

declare(strict_types=1);

namespace PixieMedia\ServerPush\Plugin;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Event\ManagerInterface;
use PixieMedia\ServerPush\Model\Output\OutputChainInterface;

class ProcessPageResult
{
    public const EVENT_NAME = 'pixiemedia_serverpush_after_process_page_result';

    /**
     * @var OutputChainInterface
     */
    private $outputChain;

    /**
     * @var ManagerInterface
     */
    private $eventManager;

    public function __construct(
        OutputChainInterface $outputChain,
        ManagerInterface $eventManager
    ) {
        $this->outputChain = $outputChain;
        $this->eventManager = $eventManager;
    }

    public function aroundRenderResult(
        ResultInterface $subject,
        \Closure $proceed,
        ResponseInterface $response
    ): ResultInterface {
        /** @var ResultInterface $result */
        $result = $proceed($response);
        $output = $response->getBody();

        if ($this->outputChain->process($output)) {
            $response->setBody($output);
        }

        $this->eventManager->dispatch(self::EVENT_NAME, ['response' => $response]);

        return $result;
    }
}
