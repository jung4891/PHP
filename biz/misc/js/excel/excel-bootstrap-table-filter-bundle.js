(function ($$1) {
    'use strict';

    $$1 = 'default' in $$1 ? $$1['default'] : $$1;

    var table_id='';
    var FilterMenu = function () {
        function FilterMenu(target, th, column, index, options) {
            this.options = options;
            this.th = th;
            this.column = column;
            this.index = index;
            if($(th).attr("filter_column") != undefined){ // rowspan 있을때 ㅋㅎㅋㅎ 핵빡침
                var filter_column = $(th).attr("filter_column");
                this.tds = target.find('tbody tr td[filter_column='+filter_column+']').toArray();
            }else{//기존방식!
                this.tds = target.find('tbody tr td:nth-child(' + (this.column + 1) + ')').toArray();
            }
        }
        FilterMenu.prototype.initialize = function () {
            this.menu = this.dropdownFilterDropdown();
            this.th.appendChild(this.menu);
            var $trigger = $(this.menu.children[0]);
            var $content = $(this.menu.children[1]);
            var $menu = $(this.menu);
            $trigger.click(function () {
                return $content.toggle();
            });
            $(document).click(function (el) {
                if (!$menu.is(el.target) && $menu.has(el.target).length === 0) {
                    $content.hide();
                }
            });
        };
        FilterMenu.prototype.searchToggle = function (value) {
            if (this.selectAllCheckbox instanceof HTMLInputElement) this.selectAllCheckbox.checked = false;
            if (value.length === 0) {
                this.toggleAll(true);
                if (this.selectAllCheckbox instanceof HTMLInputElement) this.selectAllCheckbox.checked = true;
                return;
            }
            this.toggleAll(false);
            this.inputs.filter(function (input) {
                return input.value.toLowerCase().indexOf(value.toLowerCase()) > -1;
            }).forEach(function (input) {
                input.checked = true;
            });
        };
        FilterMenu.prototype.updateSelectAll = function () {
            if (this.selectAllCheckbox instanceof HTMLInputElement) {
                $(this.searchFilter).val('');
                this.selectAllCheckbox.checked = this.inputs.length === this.inputs.filter(function (input) {
                    return input.checked;
                }).length;
            }
        };
        FilterMenu.prototype.selectAllUpdate = function (checked) {
            $(this.searchFilter).val('');
            this.toggleAll(checked);
        };
        FilterMenu.prototype.toggleAll = function (checked) {
            for (var i = 0; i < this.inputs.length; i++) {
                var input = this.inputs[i];
                if (input instanceof HTMLInputElement) input.checked = checked;
            }
        };
        FilterMenu.prototype.dropdownFilterItem = function (td, self) {
            var value ='';
            if($(td).find("input").length > 0){
                value = $(td).find("input").val();
            }else if($(td).find("select").length > 0){
                value = $(td).find("select option:selected").text();
            }else{
                value = td.innerText;
            }

            var dropdownFilterItem = document.createElement('div');
            dropdownFilterItem.className = 'dropdown-filter-item';
            var input = document.createElement('input');
            input.type = 'checkbox';
            input.value = value.trim().replace(/ +(?= )/g, '');
            input.setAttribute('checked', 'checked');
            input.className = 'dropdown-filter-menu-item item';
            input.setAttribute('data-column', self.column.toString());
            input.setAttribute('data-index', self.index.toString());
            dropdownFilterItem.appendChild(input);
            dropdownFilterItem.innerHTML = dropdownFilterItem.innerHTML.trim() + ' ' + value;
            return dropdownFilterItem;
        };
        FilterMenu.prototype.dropdownFilterItemSelectAll = function () {
            var value = this.options.captions.select_all;
            var dropdownFilterItemSelectAll = document.createElement('div');
            dropdownFilterItemSelectAll.className = 'dropdown-filter-item';
            var input = document.createElement('input');
            input.type = 'checkbox';
            input.value = this.options.captions.select_all;
            input.setAttribute('checked', 'checked');
            input.className = 'dropdown-filter-menu-item select-all';
            input.setAttribute('data-column', this.column.toString());
            input.setAttribute('data-index', this.index.toString());
            dropdownFilterItemSelectAll.appendChild(input);
            dropdownFilterItemSelectAll.innerHTML = dropdownFilterItemSelectAll.innerHTML + ' ' + value;
            return dropdownFilterItemSelectAll;
        };
        FilterMenu.prototype.dropdownFilterSearch = function () {
            var dropdownFilterItem = document.createElement('div');
            dropdownFilterItem.className = 'dropdown-filter-search';
            var input = document.createElement('input');
            input.type = 'text';
            input.className = 'dropdown-filter-menu-search form-control';
            input.setAttribute('data-column', this.column.toString());
            input.setAttribute('data-index', this.index.toString());
            input.setAttribute('placeholder', this.options.captions.search);
            dropdownFilterItem.appendChild(input);
            return dropdownFilterItem;
        };
        FilterMenu.prototype.dropdownFilterSort = function (direction) {
            var dropdownFilterItem = document.createElement('div');
            dropdownFilterItem.className = 'dropdown-filter-sort';
            var span = document.createElement('span');
            span.className = direction.toLowerCase().split(' ').join('-');
            span.setAttribute('data-column', this.column.toString());
            span.setAttribute('data-index', this.index.toString());
            span.innerText = direction;
            dropdownFilterItem.appendChild(span);
            return dropdownFilterItem;
        };
        FilterMenu.prototype.dropdownFilterContent = function () {
            var _this = this;
            var self = this;
            var dropdownFilterContent = document.createElement('div');
            if ($(this.th).hasClass('last-th')){
                dropdownFilterContent.className = 'dropdown-filter-content last-th-filter-content';
            } else {
                dropdownFilterContent.className = 'dropdown-filter-content';
            }
            var innerDivs = this.tds.reduce(function (arr, el) {
                var values = arr.map(function (el) {
                    //선영수정
                    if($(el).find("input").length > 0){
                        return $(el).find("input").val();
                    }else if($(el).find("select").length > 0){
                        return $(el).find("select option:selected").text();
                    }else{
                        return el.innerText.trim();

                    }
                });
                //선영수정
                if($(el).find("input").length > 0){
                    var txt =  $(el).find("input").val();
                    if (values.indexOf(txt.trim()) < 0) arr.push(el);
                }else if($(el).find("select").length > 0){
                    var txt = $(el).find("select option:selected").text();
                    if (values.indexOf(txt.trim()) < 0) arr.push(el);
                }else{
                    if (values.indexOf(el.innerText.trim()) < 0) arr.push(el);
                }

                return arr;
            }, []).sort(function (a, b) {
                var A = a.innerText.toLowerCase();
                var B = b.innerText.toLowerCase();
                if (!isNaN(Number(A)) && !isNaN(Number(B))) {
                    if (Number(A) < Number(B)) return -1;
                    if (Number(A) > Number(B)) return 1;
                } else {
                    if (A < B) return -1;
                    if (A > B) return 1;
                }
                return 0;
            }).map(function (td) {
                return _this.dropdownFilterItem(td, self);
            });
            this.inputs = innerDivs.map(function (div) {
                return div.firstElementChild;
            });
            var selectAllCheckboxDiv = this.dropdownFilterItemSelectAll();
            this.selectAllCheckbox = selectAllCheckboxDiv.firstElementChild;
            innerDivs.unshift(selectAllCheckboxDiv);
            var searchFilterDiv = this.dropdownFilterSearch();
            this.searchFilter = searchFilterDiv.firstElementChild;
            var outerDiv = innerDivs.reduce(function (outerDiv, innerDiv) {
                outerDiv.appendChild(innerDiv);
                return outerDiv;
            }, document.createElement('div'));
            outerDiv.className = 'checkbox-container';
            var elements = [];
            if (this.options.sort) elements = elements.concat([this.dropdownFilterSort(this.options.captions.a_to_z), this.dropdownFilterSort(this.options.captions.z_to_a)]);
            if (this.options.search) elements.push(searchFilterDiv);
            return elements.concat(outerDiv).reduce(function (html, el) {
                html.appendChild(el);
                return html;
            }, dropdownFilterContent);
        };
        FilterMenu.prototype.dropdownFilterDropdown = function () {
            var dropdownFilterDropdown = document.createElement('div');
            dropdownFilterDropdown.className = 'dropdown-filter-dropdown';
            var arrow = document.createElement('span');
            arrow.className = 'glyphicon glyphicon-arrow-down dropdown-filter-icon';
            var icon = document.createElement('i');
            icon.className = 'arrow-down';
            arrow.appendChild(icon);
            dropdownFilterDropdown.appendChild(arrow);
            dropdownFilterDropdown.appendChild(this.dropdownFilterContent());
            if ($(this.th).hasClass('no-sort')) {
                $(dropdownFilterDropdown).find('.dropdown-filter-sort').remove();
            }
            if ($(this.th).hasClass('no-filter')) {
                $(dropdownFilterDropdown).find('.checkbox-container').remove();
            }
            if ($(this.th).hasClass('no-search')) {
                $(dropdownFilterDropdown).find('.dropdown-filter-search').remove();
            }
            return dropdownFilterDropdown;
        };
        return FilterMenu;
    }();

    var FilterCollection = function () {
        function FilterCollection(target, options) {
            this.target = target;
            this.options = options;
            this.ths = target.find('th' + options.columnSelector).toArray();
            this.filterMenus = this.ths.map(function (th, index) {
                var column = $(th).index();
                return new FilterMenu(target, th, column, index, options);
            });
            this.rows = target.find('tbody').find('tr').toArray();
            this.table = target.get(0);
        }
        FilterCollection.prototype.initialize = function () {
            this.filterMenus.forEach(function (filterMenu) {
                filterMenu.initialize();
            });
            this.bindCheckboxes();
            this.bindSelectAllCheckboxes();
            this.bindSort();
            this.bindSearch();
        };
        FilterCollection.prototype.bindCheckboxes = function () {
            var filterMenus = this.filterMenus;
            var rows = this.rows;
            var ths = this.ths;
            var updateRowVisibility = this.updateRowVisibility;
            this.target.find('.dropdown-filter-menu-item.item').change(function () {
                var index = $(this).data('index');
                var value = $(this).val();
                filterMenus[index].updateSelectAll();
                updateRowVisibility(filterMenus, rows, ths);
            });
        };
        FilterCollection.prototype.bindSelectAllCheckboxes = function () {
            var filterMenus = this.filterMenus;
            var rows = this.rows;
            var ths = this.ths;
            var updateRowVisibility = this.updateRowVisibility;
            this.target.find('.dropdown-filter-menu-item.select-all').change(function () {
                var index = $(this).data('index');
                var value = this.checked;
                filterMenus[index].selectAllUpdate(value);
                updateRowVisibility(filterMenus, rows, ths);
            });
        };
        FilterCollection.prototype.bindSort = function () {
            var filterMenus = this.filterMenus;
            var rows = this.rows;
            var ths = this.ths;
            var sort = this.sort;
            var table = this.table;
            var options = this.options;
            var updateRowVisibility = this.updateRowVisibility;
            this.target.find('.dropdown-filter-sort').click(function () {
                var $sortElement = $(this).find('span');
                var column = $sortElement.data('column');
                var order = $sortElement.attr('class');
                sort(column, order, table, options);
                updateRowVisibility(filterMenus, rows, ths);
            });
        };
        FilterCollection.prototype.bindSearch = function () {
            var filterMenus = this.filterMenus;
            var rows = this.rows;
            var ths = this.ths;
            var updateRowVisibility = this.updateRowVisibility;
            this.target.find('.dropdown-filter-search').keyup(function () {
                var $input = $(this).find('input');
                var index = $input.data('index');
                var value = $input.val();
                filterMenus[index].searchToggle(value);
                updateRowVisibility(filterMenus, rows, ths);
            });
        };
        FilterCollection.prototype.updateRowVisibility = function (filterMenus, rows, ths ,target) {
            var showRows = rows;
            var hideRows = [];
            var selectedLists = filterMenus.map(function (filterMenu) {
                return {
                    column: filterMenu.column,
                    selected: filterMenu.inputs.filter(function (input) {
                        return input.checked;
                    }).map(function (input) {
                        return input.value.trim().replace(/ +(?= )/g, '');
                    }),
                    //선영추가
                    filter_column:$(filterMenu.th).attr('filter_column')
                };
            });
            for (var i = 0; i < rows.length; i++) {
                var tds = rows[i].children;
                for (var j = 0; j < selectedLists.length; j++) {
                    if(selectedLists[j].filter_column != undefined){ // rowspan 있을때 ㅋㅎㅋㅎ 핵빡침
                        var filter_column = selectedLists[j].filter_column;
                        var col = $(rows[i]).find('td[filter_column='+filter_column+']');
                        col = col[0];
                    }else{
                        var col = tds[selectedLists[j].column];
                    }

                    var content ='';

                    if(col != undefined){
                        if($(col).find("input").length > 0 ){
                            content = $(col).find("input").val();
                        }else if ($(col).find("select").length > 0){
                            content = $(col).find("select option:selected").text();
                        }else{
                            content = col.innerText.trim().replace(/ +(?= )/g, '');
                        }
                        if (selectedLists[j].selected.indexOf(content) === -1) {
                            if($(col).attr('rowSpan') == undefined || $(col).attr('rowSpan') == 1){
                                var td = $(col).parent().find('td');
                                for(var k=0; k<td.length; k++){
                                    if($(td.eq(k)).attr('rowSpan') == undefined ||td.eq(k).attr('rowSpan') == 1){
                                        $(td.eq(k)).hide();
                                    }
                                }
                            }else{
                                var rowspan = $(col).attr('rowSpan');
                                var jump = Number(i)+Number(rowspan);
                                for(var k=0; k < rowspan; k++){
                                    $(rows[i+k]).hide();
                                }
                            }
                            break;
                        }
                    }
                    if(jump != undefined){
                        if(i >= jump){
                            // console.log("점프!",jump);
                            $(rows[i]).show();
                            $(rows[i]).find('td').show();
                        }
                    }else{
                        // console.log($(rows[i]));
                        $(rows[i]).show();
                        $(rows[i]).find('td').show();
                    }
                }
            }
            // var table_id = $(tds).eq(0).parent().parent().parent().attr("id");
            table_id= $(ths).parent().parent().parent().attr("id");

            //선영수정
            var url = window.location.href;
            if(url.indexOf("forcasting_input") !== -1 || url.indexOf("forcasting_modify") !== -1 ||url.indexOf("maintain_modify") !== -1 || url.indexOf("order_completed_modify") !== -1 ){
                var table = $("#"+table_id);
                $(table).find($(".filter_n")).val('');
                for(var i=0; i<$(table).find($(".dropdown-filter-menu-item")).length; i++){
                   var filter_num = $(table).find($(".dropdown-filter-menu-item")).eq(i).attr("data-index");
                   if($(table).find($(".dropdown-filter-menu-item")).eq(i).prop("checked") == true){
                     var val = $(table).find($(".filter_n")).eq(filter_num).val()+'||'+$(table).find($(".dropdown-filter-menu-item")).eq(i).val();
                     $(table).find($(".filter_n")).eq(filter_num).val(val)
                   }
                }

                if(table_id == "sales_statement_table"){
                    $("#chk_all_1").prop("checked",false);
                    $(".checkbox_1").prop("checked", false);
                }
                if(table_id == "purchase_statement_table"){
                    $("#chk_all_2").prop("checked",false);
                    $(".checkbox_2").prop("checked", false);
                    for(var i=0; i<$("input[name=sum_purchase_issuance_amount]").length; i++){
                    }
                }
            }

            if(table_id == "sales_statement_table"){
                get_sum_amount(0);
            }
            if(table_id == "purchase_statement_table"){
                for(var i=0; i<$("input[name=sum_purchase_issuance_amount]").length; i++){
                    get_sum_amount(1,i+1);	
                }
            }

            if(table_id == "product_table" || table_id == "integration_product_table"){
                $("input[name=product_row]").prop("checked", false);
                $("#allCheck").prop("checked",false);
                filter_profit_change();
            }

            if(table_id == "funds_list_detail_view"){
              sum_in_out_come();
            }
            /////////////////////////////
        };
        FilterCollection.prototype.sort = function (column, order, table, options) {
            var flip = 1;
            if (order === options.captions.z_to_a.toLowerCase().split(' ').join('-')) flip = -1;
            var tbody = $(table).find('tbody').get(0);
            var rows = $(tbody).find('tr').get();
            rows.sort(function (a, b) {
                var A = a.children[column].innerText.toUpperCase();
                var B = b.children[column].innerText.toUpperCase();
                if (!isNaN(Number(A)) && !isNaN(Number(B))) {
                    if (Number(A) < Number(B)) return -1 * flip;
                    if (Number(A) > Number(B)) return 1 * flip;
                } else {
                    if (A < B) return -1 * flip;
                    if (A > B) return 1 * flip;
                }
                return 0;
            });
            for (var i = 0; i < rows.length; i++) {
                tbody.appendChild(rows[i]);
            }
        };
        return FilterCollection;
    }();

    $$1.fn.excelTableFilter = function (options) {
        var target = this;
        options = $$1.extend({}, $$1.fn.excelTableFilter.options, options);
        if (typeof options.columnSelector === 'undefined') options.columnSelector = '';
        if (typeof options.sort === 'undefined') options.sort = true;
        if (typeof options.search === 'undefined') options.search = true;
        if (typeof options.captions === 'undefined') options.captions = {
            a_to_z: 'A to Z',
            z_to_a: 'Z to A',
            search: 'Search',
            select_all: 'Select All'
        };
        var filterCollection = new FilterCollection(target, options);
        filterCollection.initialize();
        // 선영수정
        for(var i=0; i<$(target).find($(".filter_n")).length; i++){
            if($(target).find($(".filter_n")).eq(i).val() != "all"){
                var chk = ($(target).find($(".filter_n")).eq(i).val().replace("||","")).split('||');
                if(chk.length > 0){
                    for(var j=0; j<$(target).find($(".dropdown-filter-menu-item")).length; j++){
                        if($(target).find($(".dropdown-filter-menu-item")).eq(j).attr('data-index') == i){
                            $(target).find($(".dropdown-filter-menu-item")).eq(j).prop("checked",false);
                            for(var k=0; k<chk.length; k++){
                                if($(target).find($(".dropdown-filter-menu-item")).eq(j).val() == chk[k]){
                                    $(target).find($(".dropdown-filter-menu-item")).eq(j).prop("checked",true);
                                }
                            }
                        }
                    }
                }
            }
        }
        /////////////////////////////
        return target;
    };
    $$1.fn.excelTableFilter.options = {};
    }(jQuery));
    //# sourceMappingURL=excel-bootstrap-table-filter-bundle.js.map
