import Plugin from '@ckeditor/ckeditor5-core/src/plugin';
import Widget from '@ckeditor/ckeditor5-widget/src/widget';

export default class InlineWidgetPlugin extends Plugin {
    static get requires() {
        return [ Widget ];
    }

    static get pluginName() {
        return 'InlineWidget';
    }

    init() {
        this.editor.plugins.get( Widget ).registerView( 'inlineWidget', ( modelElement, writer ) => {
            return {
                render() {
                    const container = document.createElement( 'span' );
                    container.classList.add( 'inline-widget' );
                    container.textContent = modelElement.getAttribute( 'data-content' ) || 'Inline Widget';

                    return container;
                }
            };
        });

        this.editor.plugins.get( Widget ).registerDataView( 'inlineWidget', ( model, viewWriter ) => {
            return viewWriter.createContainerElement( 'span', {
                class: 'inline-widget',
                'data-content': model.getAttribute( 'data-content' ) || 'Inline Widget'
            } );
        } );

        this.editor.commands.add( 'insertInlineWidget', {
            execute( content ) {
                this.editor.model.change( writer => {
                    const inlineWidget = writer.createElement( 'inlineWidget', { 'data-content': content || 'Inline Widget' } );
                    this.editor.model.insertContent( inlineWidget );
                } );
            }
        } );
    }
}