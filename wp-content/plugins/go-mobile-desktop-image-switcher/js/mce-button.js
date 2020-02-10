tinymce.PluginManager.add('go_mobile_desktop_image_switcher', function (editor) {
  var toolbar;

  function handleImageClick(e, prop, title) {
    e.preventDefault();

    const selector = wp.media.frames.file_frame = wp.media({
      title,
      button: {
        text: 'Select'
      },
      multiple: false
    });
    selector.on('select', function () {
      const attachment = selector.state().get('selection').first().toJSON();
      const url = attachment.url;

      const input = document.getElementById(prop);
      input.value = url;

      const img = document.querySelector('img.' + prop);
      img.src = url;
    });
    selector.open();
  }

  function getPictureNode(node) {
    var dom = editor.dom;

    if (node.nodeName === 'PICTURE' && dom.hasClass(node, 'mobile-desktop')) {
      return node;
    }

    var parent = dom.getParent(node, 'picture.mobile-desktop');
    if (parent) {
      return parent;
    }

    return null;
  }

  function extractImageData(pictureNode) {
    var dom = editor.dom;

    var data = {
      mobileImage: '',
      desktopImage: ''
    };

    data.desktopImage = dom.getAttrib(pictureNode.childNodes[0], 'srcset');
    data.mobileImage = dom.getAttrib(pictureNode.childNodes[1], 'srcset');

    return data;
  }

  function removeImage(node) {
    var picture = getPictureNode(node);

    if (picture) {
      editor.dom.remove(picture);
    } else {
      console.error('Failed to find picture node');
    }

    editor.nodeChanged();
    editor.undoManager.add();
  }

  editor.addButton('go_img_remove', {
    tooltip: 'Remove',
    icon: 'dashicon dashicons-no',
    onclick: function () {
      removeImage(editor.selection.getNode());
    }
  });

  function editImage(node) {
    const picture = getPictureNode(node);
    const imageData = extractImageData(picture);

    const data = {
      ...imageData,
      existingNode: node
    };

    editor.execCommand('go_mobile_desktop_image_switcher_window', '', data);
  }

  editor.addButton('go_img_edit', {
    tooltip: 'Edit ',
    icon: 'dashicon dashicons-edit',
    onclick: function () {
      const picture = getPictureNode(editor.selection.getNode());
      editImage(picture);
    }
  });

  // function showDesktopImage(node) {
  //   var dom = editor.dom;
  //   var picture = getPictureNode(node);
  //   var data = extractImageData(picture);

  //   dom.setAttrib(picture.childNodes[2], 'srcset', data.desktopImage);
  // }

  // editor.addButton('go_img_desktop', {
  //   tooltip: 'Show Desktop Image ',
  //   icon: 'dashicon dashicons-desktop',
  //   onclick: function () {
  //     showDesktopImage(editor.selection.getNode());
  //   }
  // });

  // function showMobileImage(node) {
  //   var dom = editor.dom;
  //   var picture = getPictureNode(node);
  //   var data = extractImageData(picture);

  //   dom.setAttrib(picture.childNodes[2], 'srcset', data.mobileImage);
  // }

  // editor.addButton('go_img_mobile', {
  //   tooltip: 'Show Mobile Image ',
  //   icon: 'dashicon dashicons-smartphone',
  //   onclick: function () {
  //     showMobileImage(editor.selection.getNode());
  //   }
  // });

  editor.once('preinit', function () {
    if (editor.wp && editor.wp._createToolbar) {
      toolbar = editor.wp._createToolbar([
        // 'go_img_desktop',
        // 'go_img_mobile',
        // '|',
        'go_img_edit',
        'go_img_remove'
      ]);
    }
  });

  editor.on('wptoolbar', function (event) {
    var pictureNode = getPictureNode(event.element);
    if (pictureNode) {
      event.toolbar = toolbar;
    }
  });

  function buildImageElement(imgClass, src) {
    let divStyle = 'margin: 2px;';
    divStyle += 'border: 1px solid grey;';
    divStyle += 'display: flex;';
    divStyle += 'flex-direction: column;';
    divStyle += 'justify-content: center;';
    divStyle += 'align-items: center;';
    divStyle += 'background-color: #f1f1f1;';
    divStyle += 'width: 300px; ';
    divStyle += 'height: 300px;';

    let imgStyle = 'max-width: 300px;';
    imgStyle += 'max-height: 300px';

    let html = '<div style="' + divStyle + '">';
    html += '<img class="' + imgClass + '" src="' + src + '" style="' + imgStyle + '" />';
    html += '</div>';

    return html;
  }

  editor.addCommand('go_mobile_desktop_image_switcher_window', function (ui, data) {
    const mobileImage = data.mobileImage ? data.mobileImage : '';
    const desktopImage = data.desktopImage ? data.desktopImage : '';
    const existingNode = data.existingNode;

    const mobileImageHtml = buildImageElement('mobile-image', mobileImage);
    const desktopImageHtml = buildImageElement('desktop-image', desktopImage);

    const window = editor.windowManager.open({
      title: 'Mobile + Desktop Image',
      body: [
        {
          type: 'container',
          layout: 'flex',
          direction: 'row',
          align: 'stretch',
          items: [
            {
              type: 'container',
              layout: 'flex',
              direction: 'column',
              items: [
                {
                  type: 'label',
                  text: 'Mobile Image'
                },
                {
                  type: 'textbox',
                  hidden: true,
                  name: 'mobile-image',
                  id: 'mobile-image',
                  value: mobileImage
                },
                {
                  type: 'container',
                  html: mobileImageHtml,
                  onclick: function (e) {
                    handleImageClick(e, 'mobile-image', 'Mobile Image');
                  }
                }
              ]
            },
            {
              type: 'container',
              layout: 'flex',
              direction: 'column',
              items: [
                {
                  type: 'label',
                  text: 'Desktop Image'
                },
                {
                  type: 'textbox',
                  hidden: true,
                  name: 'desktop-image',
                  id: 'desktop-image',
                  value: desktopImage
                },
                {
                  type: 'container',
                  html: desktopImageHtml,
                  onclick: function (e) {
                    handleImageClick(e, 'desktop-image', 'Desktop Image');
                  }
                }
              ]
            }
          ]
        }
      ],
      onsubmit: function (e) {
        const data = window.toJSON();

        const mobileImage = data['mobile-image'];
        const desktopImage = data['desktop-image'];

        const dom = editor.dom;

        const innerHtml =
          dom.createHTML('source', { srcset: desktopImage, media: '(min-width: 800px)' }) +
          dom.createHTML('source', { srcset: mobileImage }) +
          dom.createHTML('img', { class: 'aligncenter size-full', srcset: desktopImage });

        if (existingNode != null) {
          dom.setHTML(existingNode, innerHtml);
        } else {
          const html = dom.createHTML('picture', { class: 'mobile-desktop' }, innerHtml);
          editor.insertContent(html);
        }
      }
    });
  });

  editor.addButton('go_mobile_desktop_image_switcher', {
    icon: 'dashicon dashicons-format-image',
    text: ' Add Mobile + Desktop Image',
    onclick: function () {
      editor.execCommand('go_mobile_desktop_image_switcher_window', '', {});
    }
  });

  editor.wp = editor.wp || {};

});
