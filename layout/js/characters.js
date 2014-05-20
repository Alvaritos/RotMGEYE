/**
 * Created by Alvaro on 5/20/14.
 */


function drawCharacters() {
    var
        offsets = sheetOffsets,
        sheets = new Image();
    sheets.onload = draw;
    sheets.src = sheetSrc;
    function draw() {
        var
            offset = 0,
            toRender = {},
            dyes = {},
            size = 42,
            characters = document.createElement('canvas'),
            ctx = characters.getContext('2d'),
            buffer1 = document.createElement('canvas'),
            b1ctx = buffer1.getContext('2d'),
            buffer2 = document.createElement('canvas'),
            b2ctx = buffer2.getContext('2d');
        $('.character').each(function() {
            var
                data = $(this).data(),
                key = _.map([ 'class', 'skin', 'dye1', 'dye2'], function(dataSelector) {
                    return data[dataSelector];
                }).join('.');
            if (toRender[key]) {
                toRender[key]['elements'].push(this);
            } else {
                toRender[key] = {
                    data: data,
                    offset: offset,
                    elements: [ this ]
                };
                offset++;
            }
        });
        characters.height = buffer1.height = buffer1.width = buffer2.height = buffer1.width = size;
        characters.width = size * offset;
        _.each(toRender, function(item) {
            render(item);
        });
        var css = [];
        css.push('<style> .character { background-image: url(');
        css.push(characters.toDataURL());
        css.push(') } ');
        _.each(toRender, function(item) {
            _.each(item.elements, function (element) {
                css.push('#')
                css.push(element.id)
                css.push(' { background-position: ')
                css.push(-42 * item.offset)
                css.push('px 0 !important }\n');
            });
        });
        css.push('</style>');
        $('head').append(css.join(''));

        function render(item) {
            if (!item.data.class) { return; }
            var info = classInfoById[item.data.class];
            var skin = _.detect(info[6], function(each) { return each[0] == item.data.skin; }) || info[6][0];
            var offset = skin[2] * size,
                pcanvas, pctx;
            renderSprite(ctx, offset, 0, item.offset);
            if (item.data.dye1) { renderDye(item.data.dye1, 1); }
            if (item.data.dye2) { renderDye(item.data.dye2, 3); }

            function renderSprite(context, offsetYOnTheSheet, column, drawOffset) {
                context.drawImage(sheets, column * size, offsetYOnTheSheet, size, size, drawOffset * size, 0, size, size);
            }

            function renderDye(dyeId, dyeColumn) {
                b2ctx.globalCompositeOperation = 'source-over';
                b1ctx.clearRect(0, 0, size, size);
                b2ctx.clearRect(0, 0, size, size);
                renderSprite(b2ctx, offset, dyeColumn, 0);
                setFillStyleFor(dyeId);
                b2ctx.globalCompositeOperation = 'source-in';
                b2ctx.save();
                b2ctx.translate(1,1);
                b2ctx.fillRect(0, 0, size, size);
                b2ctx.restore();
                renderSprite(b1ctx, offset, dyeColumn + 1, 0);
                b1ctx.drawImage(buffer2, 0, 0, size, size, 0, 0, size, size);
                ctx.drawImage(buffer1, 0, 0, size, size, item.offset * size, 0, size, size);
            }

            function setFillStyleFor(dyeId) {
                if (!dyes[dyeId]) {
                    if (dyeId < 0x1000000) { // Kabam needs better inner communication. This is a workaround of their workaround of their own bug.
                        dyeId = dyeId << 20;
                    }
                    var
                        type = dyeId >> 24,
                        color = dyeId & 0xffffff;
                    if (type == 1) {
                        dyes[dyeId] = '#' + ('000000' + color.toString(16)).slice(-6);
                    } else {
                        pcanvas = pcanvas || document.createElement('canvas');
                        pctx = pctx || pcanvas.getContext('2d');
                        pcanvas.width = pcanvas.height = type;
                        pctx.clearRect(0, 0, type, type);
                        pctx.drawImage(sheets, (color % 16) * type, offsets[type] + Math.floor(color / 16) * type, type, type, 0, 0, type, type);
                        dyes[dyeId] = pctx.createPattern(pcanvas, 'repeat');
                    }
                }
                b2ctx.fillStyle = dyes[dyeId];
            }
        }
    }
}
