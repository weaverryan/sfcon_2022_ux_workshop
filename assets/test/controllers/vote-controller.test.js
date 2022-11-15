import { Application } from '@hotwired/stimulus';
import { clearDOM, mountDOM } from '@symfony/stimulus-testing';
import VoteController from '../../controllers/vote-controller';

const startStimulus = () => {
    const application = Application.start();
    application.register('vote', VoteController);
};

describe('VoteController', () => {
    let container;

    afterEach(() => {
        clearDOM();
    });

    it('connects', async () => {
        container = mountDOM(`<div data-controller="vote">
            <span data-vote-target="total">10</span> votes

            <button
                data-action="vote#upVote"
            >Up</button>
            <button
                data-action="vote#downVote"
            >Down</button>
        </div>`);

        startStimulus();

        // Write a test here ...
    });

    // You can create other tests here
});
