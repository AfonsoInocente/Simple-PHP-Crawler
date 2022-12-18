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
        $element = $HTMLAdapterInteractor->query('//input[@id="token"]');

        if (count($element) == 0) {
            throw new \Exception("O elemento que contém o Token não foi identificado.", 404);
        }

        if (count($element) > 1) {
            throw new \InvalidArgumentException("Foi encontrado mais de um Elemento com o ID Token. Por favor, verifique o código e tente novamente.", 400);
        }

        $inputElement = $element->item(0);
        $token = $inputElement->getAttribute('value');

        if (!$token) {
            throw new \Exception("Não foi possível identificar um valor para o Token. Por favor, verifique o código e tente novamente.", 404);
        }

        return $token;
    }

    public function findTheAnswer(string $element): string {
        if (!$element) {
            throw new \InvalidArgumentException("É necessário informar um HTML para prosseguir.", 400);
        }

        $this->HTMLInteractor->loadHTML($element);
        $spanElementObj = $this->HTMLInteractor->getElementById('answer');

        if (!$spanElementObj) {
            throw new \Exception("O elemento que contém a Resposta não foi identificado.", 404);
        }

        $answerText = $spanElementObj->textContent;

        if (!$answerText) {
            throw new \InvalidArgumentException("A Resposta está nula. Por favor, verifique o código e tente novamente.", 400);
        }

        return $answerText;
    }
}
