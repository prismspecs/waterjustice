wp.blocks.registerBlockType('waterjustice/swimming-quotes', {
    title: 'Swimming Quotes',
    icon: 'editor-quote',
    category: 'common',
    attributes: {
        content: { type: 'string' },
    },
    edit: function (props) {
        function updateContent(event) {
            props.setAttributes({ content: event.target.value });
        }

        return wp.element.createElement(
            'div',
            null,
            wp.element.createElement('textarea', {
                value: props.attributes.content,
                onChange: updateContent,
                placeholder: 'Enter a swimming quote...',
            })
        );
    },
    save: function (props) {
        return wp.element.createElement(
            'div',
            { className: 'swimming-quote-block' },
            props.attributes.content
        );
    },
});
