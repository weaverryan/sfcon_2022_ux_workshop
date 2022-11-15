import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['total'];

    static values = {
        url: String,
    }

    upVote() {
        this.#changeVote('up');
    }

    downVote() {
        this.#changeVote('down');
    }

    async #changeVote(direction) {
        const response = await fetch(this.urlValue, {
            method: 'POST',
            body: JSON.stringify({direction: direction})
        });

        this.element.innerHTML = await response.text();
    }
}
