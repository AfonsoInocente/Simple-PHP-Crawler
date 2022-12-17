<?php

class Interactor {
    public object $_HTMLInteractor;

    function __construct(object $InterfaceManipulator = null) {
        $this->_HTMLInteractor = $InterfaceManipulator ?? (object) [];
    }

    public function loadHTMLData(string $element): array {
        if (!$element) {
            throw new Exception("O HTML não pode ser vazio.");
        }

        libxml_use_internal_errors(true);
        $this->_HTMLInteractor->loadHTML($element);

        return [
            'Interactor' => $this->_HTMLInteractor,
            'HTML' => $element
        ];
    }

    public function findCookie(string $html): string {
        preg_match_all('/^Set-Cookie:\s*([^;]*)/im', $html, $matches);
        foreach($matches[1] as $item) {
            if (substr($item, 0, 9 ) === "PHPSESSID") {
                return $item;
            }
        }

        throw new Exception("Nenhum Cookie encontrado.");

    }

    public function getTokenValue(object $HTMLAdapterInteractor): string {
        return $HTMLAdapterInteractor->query('//input[@id="token"]')
        ->item(0)
        ->getAttribute('value');
    }

    public function findTheAnswer(string $element): string {
        $this->_HTMLInteractor->loadHTML($element);
        $spanElementObj = $this->_HTMLInteractor->getElementById('answer');
        $answerText = $spanElementObj->textContent;
        return $answerText;
    }
}
