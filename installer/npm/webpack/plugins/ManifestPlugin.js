import fs from 'fs';
import path from 'path';

class ManifestPlugin {

    constructor(path) {
        this.path = path;
        this.name = 'mix-manifest.json';
        this.manifest = {};
    }

    getAsset(assets){
        for(let x in assets){
            if(typeof assets[x] === 'object'){
                this.getAsset(assets[x])
            } else {
                let original = assets[x].replace(/\?v=\w{20}/, '');
                this.manifest[original] = assets[x];
            }
        }
    }

    /**
     * Apply the plugin.
     *
     * @param {Object} compiler
     */
    apply(compiler) {
        compiler.hooks.emit.tap('emit', (compiler) => {
            let stats = compiler.getStats().toJson();
            let assets = Object.assign({}, stats.assetsByChunkName);
            this.getAsset(assets);
            this.manifest = JSON.stringify(this.manifest, null, 4);
            fs.writeFileSync(path.join(this.path, this.name), this.manifest);
        });
    }
}

module.exports = ManifestPlugin;
