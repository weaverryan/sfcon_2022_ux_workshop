import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['total'];

    upVote() {
        this.#changeVote('up');
    }

    downVote() {
        this.#changeVote('down');
    }

    #changeVote(direction) {
        const total = parseInt(this.totalTarget.innerHTML.trim());
        const change = direction === 'up' ? 1 : -1;

        this.totalTarget.innerHTML = total + change;
    }
}
