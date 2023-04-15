# FusionFiles
***
Serve different file formats with Neos.Fusion
***

## Available formats
* json
* pdf (with additional package Kleisli.FusionFiles.Pdf)

## Json
To render a node `My.NodeType` as json, just add a fusion prototype `My.NodeType.Json` that 
extends `Kleisli.FusionFiles:File.Json` and add the json values to the data property.

### Eel helper
This package has its own eel helper `FusionFiles.Json` to jsonify, because the core eel helper fails to 
replace the Neos cache markers correctly.

### Example
```
prototype(My.App:Document.List.Json) < prototype(Kleisli.FusionFiles:File.Json) {
    data {
        value = 'ok'
        getValueFromPrototype = My.App:Component.ListAsArray
    }
}
```
on requesting https://your.domain/path/to/node.json the response will be something like
```
{
    "value" : "ok",
    "getValueFromPrototype" : [
        {"id": "abc"},
        {"id": "def"}
    ]
}
```

## Use the helpers for other file formats 
Add a `Request.fusion` file to your package with
```
root {
    // Hook into the root matcher to change rendering for fancy requests
    fancy = Kleisli.FusionFiles:Helper.RenderFileMatcher {
        fileExtension = 'fancy'
    }
}
```
to access the prototype
```
prototype(My.App:Document.List.Fancy) < prototype(Neos.Fusion:Component) {
    renderer = ''
}
```
via https://your.domain/path/to/node.fancy

## Kudos
The development of this package has significantly been funded by [Profolio](https://www.profolio.ch/) - a digital platform for career choice & career counseling
