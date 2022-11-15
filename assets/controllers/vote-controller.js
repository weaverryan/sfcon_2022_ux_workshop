import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['total'];

    upVote() {
        const total = parseInt(this.totalTarget.innerHTML.trim());

        this.totalTarget.innerHTML = total + 1;
    }
}
