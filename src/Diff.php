<?php

namespace Swaggest\JsonDiffCli;


use Yaoi\Command;

class Diff extends Base
{
    public $prettyShort;

    /**
     * @param Command\Definition $definition
     * @param \stdClass|static $options
     */
    public static function setUpDefinition(Command\Definition $definition, $options)
    {
        parent::setUpDefinition($definition, $options);
        $definition->description = 'Make patch from two json documents, output to STDOUT';
        $options->prettyShort = Command\Option::create()
            ->setDescription('Pretty short format');
    }


    public function performAction()
    {
        $this->prePerform();
        if (null === $this->diff) {
            return;
        }

        $this->out = $this->diff->getPatch();

        $outJson = $this->out->jsonSerialize();
        if ($this->prettyShort && !empty($outJson)) {
            $out = '[';
            foreach ($outJson as $item) {
                $out .= "\n    " . json_encode($item, JSON_UNESCAPED_SLASHES) . ',';
            }
            $out = substr($out, 0, -1);
            $out .= "\n]";
            $this->response->addContent($out);
            return;
        }

        $this->postPerform();
    }
}