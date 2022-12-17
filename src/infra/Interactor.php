<?php

namespace App\Infra;

class Interactor {
    public function __construct(private object $HTMLInteractor)
    {}

    public function loadHTMLData(string $element): array {
        if (!$element) {
            throw new \InvalidArgumentException("O HTML não pode ser vazio.", 400);
        }

        libxml_use_internal_errors(true);
        $this->HTMLInteractor->loadHTML($element);

        return [
            'Interactor' => $this->HTMLInteractor,
            'HTML' => $element
        ];
    }

    public function getTokenValue(object $HTMLAdapterInteractor): string {
        return $HTMLAdapterInteractor->query('//input[@id="token"]')
        ->item(0)
        ->getAttribute('value');
    }

    public function findTheAnswer(string $element): string {
        $this->HTMLInteractor->loadHTML($element);
        $spanElementObj = $this->HTMLInteractor->getElementById('answer');
        $answerText = $spanElementObj->textContent;
        return $answerText;
    }
}
