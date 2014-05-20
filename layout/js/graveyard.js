function renderDeadCharacterPopover(tableId, columnIndex) {
    $('#' + tableId + ' .character').each(function() {
        var self = $(this);
        var classInfo = classInfoById[parseInt(self.data('class'))];
        var skinId = parseInt(self.data('skin'));
        var skinInfo = _.detect(classInfo[6], function(info) {
            return info[0] == skinId;
        });
        self.popover({
            html: true,
            content: dyeTable([self.data('accessory-dye-id'), self.data('clothing-dye-id')]),
            placement: 'top',
            trigger: 'manual',
            title: classInfo[1] + ' - ' + skinInfo[1]
        });
        self.hover(
            function() { self.popover('show'); },
            function() { self.popover('hide'); }
        );

        function dyeTable(ids) {
            var table = ['<table class="character-dyes">'];
            $.each(ids, function(index, id) {
                if (id != '0' && items[id]) {
                    table.push('<tr><td><span class="item" data-item="');
                    table.push(id);
                    table.push('"></span></td><td>');
                    table.push(items[id][0]);
                    table.push('</td></tr>');
                }
            });
            table.push('</table>');
            table = $(table.join(''));
            makeItemsIn(table);
            return table;
        }
    });
}

function renderDeadCharacterStats(tableId, columnIndex) {
    $('#' + tableId + ' td:nth-child(' + columnIndex + ') span').each(function() {
        var self = $(this);
        var stats = self.data('stats');
        var diedOn = new Date(self.data('died-on')).getTime() / 1000;
        var maxes = maxesForOn(self.data('class'), diedOn);
        var maxed = [false, false, false, false, false, false, false];
        var maxedCount = 0;
        var noms = numberOfMaxableStats(diedOn);
        $.each(maxes, function(index, value) {
            maxedCount += ((maxed[index] = value == stats[index]) ? 1 : 0)
        });
        self.html(maxedCount + '/' + noms + '<i class="icon icon-info-sign"></i>');
        self.popover({
            html: true,
            content: statsTable(stats, maxed, maxes, noms),
            title: 'Base stats',
            trigger: "manual",
            template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'
        });
        self.parent().hover(function() { self.popover("show"); }, function () { self.popover("hide"); });
    });

    function maxesForOn(classId, diedOn) {
        var mapping = [ 0, 1, 2, 3, 4, 6, 7, 5 ];
        var maxesOrig = classInfoById[classId][5];
        var maxes = $.map(mapping, function(value) {
            return maxesOrig[value];
        });
        if (diedOn > 1339533420) return maxes;
        switch(classId) {
            case 768:
                maxes[5] = 75;
                break;
            case 775:
                maxes[5] = 75;
                break;
            case 782:
                maxes[5] = 75;
                maxes[6] = 75;
                break;
            case 784:
                maxes[5] = 75;
                break;
            case 799:
                maxes[5] = 75;
                maxes[6] = 50;
                break;
            case 800:
                maxes[5] = 75;
                maxes[4] = 50;
                break;
            case 802:
                maxes[5] = 75;
                break;
            case 803:
                maxes[5] = 75;
                break;
            case 801:
                maxes[5] = 50;
                break;
            case 804:
                maxes[5] = 75;
                maxes[2] = 65;
                maxes[4] = 70;
                maxes[7] = 70;
                break;
        }
        if (diedOn > 1301377140) return maxes;
        switch (classId) {
            case 798:
                maxes[3] = 50;
                break;
            case 800:
                maxes[2] = 50;
                maxes[7] = 50;
                break;
            case 801:
                maxes[2] = 75;
                maxes[7] = 75;
                break;
        }
        return maxes;
    }

    function numberOfMaxableStats(diedOn) {
        if (diedOn < 1322439660) return 6;
        if (diedOn < 1329172860) return 7;
        return 8;
    }

    function statsTable(stats, maxedArr, maxes, noms) {
        var statNames = ["HP", "MP", "ATT", "DEF", "SPD", "VIT", "WIS", "DEX"];
        var table = ['<table class="stats-table">'];
        addRow(0, 1);
        addRow(2, 4);
        addRow(5, 7);
        table.push('</table>');
        return table.join('');

        function addRow(from, to) {
            var allMaxed = true;
            table.push('<tr>');
            for(var i = from; i <= to; ++i) {
                addCell(statNames[i], maxedArr[i], stats[i]);
                allMaxed &= !maxable(statNames[i]) || maxedArr[i];
            }
            padRowToThreeCells(from, to);
            table.push('</tr>');
            if (!allMaxed) {
                addToMaxRow(from, to);
            }
        }

        function addToMaxRow(from, to) {
            table.push('<tr>');
            for(var i = from; i <= to; ++i) {
                addToMaxCell(statNames[i], maxedArr[i], stats[i], maxes[i]);
            }
            padRowToThreeCells(from, to);
            table.push('</tr>');
        }

        function addCell(name, maxed, stat) {
            table.push('<td');
            if (maxed && maxable(name)) { table.push(' class="maxed"'); }
            table.push('>');
            table.push(name);
            table.push(': ');
            table.push(stat);
            table.push('</td>');
        }

        function addToMaxCell(name, maxed, stat, max) {
            table.push('<td class="to-max">');
            if (!maxed && maxable(name)) {
                table.push(max - stat);
                if (name == 'HP' || name == 'MP') {
                    table.push(' (');
                    table.push(Math.ceil((max - stat) / 5));
                    table.push(')');
                }
                table.push(' to max');
            }
            table.push('</td>');
        }

        function padRowToThreeCells(from, to) {
            for(i = 0; i < 3 - (to - from + 1); ++i) {
                table.push('<td></td>');
            }
        }

        function maxable(name) {
            switch(noms) {
                case 8:
                    return true;
                case 7:
                    return (name != 'MP');
                case 6:
                    return (name != 'MP') && (name != 'HP');
            }
        }
    }
}

function renderFameBonusesPopover(tableId, columnIndex) {
    var bonusNames = ["Accurate", "Ancestor", "Boots on the Ground", "Cartographer", "Friend of the Cubes", "Doer of Deeds", "Explorer", "First Born", "Enemy of the Gods", "Slayer of the Gods", "Leader of Men", "Legacy Builder", "Mundane", "Oryx Slayer", "Pacifist", "Sharpshooter", "Sniper", "Team Player", "Thirsty", "Tunnel Rat", "Well Equipped"];
    $('#' + tableId + ' td:nth-child(' + columnIndex + ') span').each(function() {
        var self = $(this);
        self.append('<i class="icon icon-info-sign"></i>');
        self.popover({
            html: true,
            content: bonusesTable(self.data('bonuses')),
            title: 'Bonuses',
            trigger: 'manual',
            template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'
        });
        self.parent().hover(function() { self.popover("show"); }, function () { self.popover("hide"); });
    });

    function bonusesTable(bonuses) {
        var table = ['<table class="stats-table bonus-table"><thead><tr><th>Bonus</th><th>Fame</th></tr></thead><tbody>'];
        var bonusCount = 0;
        var bonusSum = 0;
        $.each(bonusNames, function(index, name) {
            if (bonuses[index]) {
                bonusCount++;
                bonusSum += bonuses[index];
                table.push('<tr><td>');
                table.push(name);
                table.push('</td><td>');
                table.push(bonuses[index]);
                table.push('</td></tr>');
            }
        });
        if (bonusCount == 0) {
            return 'No bonuses';
        }
        if (bonusCount > 1) {
            table.push('<tr class="total"><td>Sum</td><td>');
            table.push(bonusSum);
            table.push('</td>');
        }
        table.push('</tbody></table>');
        return table.join('');
    }
}
