import notifier from 'node-notifier';

class NotifyPlugin {
    /**
     * Handle the deletion of the temporary mix.js
     * output file that was generated by webpack.
     *
     * This file is created when the user hasn't
     * requested any JavaScript compilation, but
     * webpack still requires an entry.
     *
     * @param {Object} compiler
     */
    apply(compiler) {
        compiler.hooks.done.tap('done', function(stats) {
            // Object
            notifier.notify({
                'title': 'My notification',
                'message': 'Hello, there!'
            });
        });
    }
}

module.exports = NotifyPlugin;