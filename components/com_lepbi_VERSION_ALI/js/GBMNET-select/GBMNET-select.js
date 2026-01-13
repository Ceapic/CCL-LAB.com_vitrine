$(document).on('change', 'select', function () {
    if (this.GBMNET_SELECT) {
        $(this).GBMNET_SELECT('refresh');
    }
});


(function ($) {
    const originalVal = $.fn.val;

    $.fn.val = function (value) {
        const result = originalVal.apply(this, arguments); // Appeler la méthode originale
        if (value !== undefined) {
            // Si on modifie la valeur
            this.each(function () {
                if (this.tagName.toLowerCase() === 'select' && this.GBMNET_SELECT) {
                    $(this).GBMNET_SELECT('refresh'); // Synchroniser automatiquement
                }
            });
        }
        return result; // Retourner la valeur originale
    };
})(jQuery);

(function ($) {
    $.fn.GBMNET_SELECT = function (action) {
        return this.each(function () {
            if (this.tagName.toLowerCase() !== 'select') {
                console.warn('L\'élément n\'est pas un select.');
                return;
            }

            if (action === 'destroy') {
                if (this.GBMNET_SELECT) {
                    this.GBMNET_SELECT.destroy();
                    delete this.GBMNET_SELECT;
                }
            } else if (action === 'refresh') {
                if (this.GBMNET_SELECT) {
                    this.GBMNET_SELECT.refresh();
                }
            } else {
                if (!this.GBMNET_SELECT) {
                    this.GBMNET_SELECT = new GBMNET_SELECT(this);
                }
            }
        });
    };

    class GBMNET_SELECT {
        constructor(selectElement, parameters = null) {
            this.selectElement = selectElement;
            this.parameters = parameters;
            this.active = false;
            this.createSearchInput();
            this.createOptionsContainer();
            this.addEventListeners();
        }

        createSearchInput() {
            // Créer un conteneur pour l'input de recherche
            this.container = document.createElement('div');
            this.container.className = 'GBMNET_SELECT-container';
            this.selectElement.parentNode.insertBefore(this.container, this.selectElement);

            // Créer et insérer l'input de recherche
            this.searchInput = document.createElement('input');
            this.searchInput.type = 'text';
            this.searchInput.className = 'GBMNET_SELECT-input';
            this.searchInput.placeholder = 'Recherchez...';
            this.container.appendChild(this.searchInput);

            this.chevron = document.createElement('i');
            this.chevron.className = 'GBMNET_SELECT-icon fa fa-angle-down';
            this.container.appendChild(this.chevron);

            // Masquer le select original
            this.selectElement.style.display = 'none';

            //TEST A DECOMMENTER SUREMENT	
            /*if (this.parameters && this.parameters.class) {
                // ajouter la class
                this.searchInput.classList.add(this.parameters.class);
            }*/

            // Récupérer le texte visible initial
            const selectedOption = this.selectElement.options[this.selectElement.selectedIndex];
            if (selectedOption != undefined) {
                const visibleText = selectedOption.dataset.visibleText || selectedOption.textContent;
                this.searchInput.value = visibleText;
            } else {
                this.searchInput.value = '';
            }

            if ($(this.selectElement).outerWidth() != 0) {
                $(this.container).css({
                    width: $(this.selectElement).outerWidth(),
                    //height: $(this.selectElement).outerHeight()
                });
            }
        }

        refresh() {
            this.updateFromSelect();
        }

        createOptionsContainer() {
            this.optionsContainer = document.createElement('div');
            this.optionsContainer.className = 'GBMNET_SELECT-options-container';

            this.populateOptionsContainer();
            if (this.selectElement.options) {
                Array.from(this.selectElement.options).forEach(option => {
                    if (option.dataset.visible == undefined) {
                        option.dataset.visible = 'true';
                    }
                });

                if (this.selectElement.selectedIndex && this.selectElement.options[this.selectElement.selectedIndex]) {
                    this.searchInput.value = this.selectElement.options[this.selectElement.selectedIndex].textContent;
                }
            }

            // this.container.appendChild(this.optionsContainer);
            document.body.appendChild(this.optionsContainer);
        }

        /* VERSION JORIS SANS OPTION GROUP
        populateOptionsContainer() {
            this.optionsContainer.innerHTML = ''; // Nettoyer les options précédentes
            const options = Array.from(this.selectElement.options);

            options.forEach(option => {
                if (option.dataset.visible === 'true' || option.dataset.visible === undefined) {
                    const optionItem = document.createElement('div');
                    optionItem.className = 'GBMNET_SELECT-option-item';
                    optionItem.textContent = option.textContent; // Texte complet pour la liste déroulante
                    optionItem.dataset.value = option.value;

                    if (option.selected) {
                        const visibleText = option.dataset.visibleText || option.textContent;
                        this.searchInput.value = visibleText; // Texte abrégé ou complet
                        optionItem.classList.add('selected');
                    }

                    this.optionsContainer.appendChild(optionItem);
                }
            });

            // Gestion de l'option sélectionnée (si aucune n'est sélectionnée)
            const selectedOption = this.selectElement.options[this.selectElement.selectedIndex];
            if (selectedOption) {
                const visibleText = selectedOption.dataset.visibleText || selectedOption.textContent;
                this.searchInput.value = visibleText;
            } else {
                this.searchInput.value = ''; // Si aucune option sélectionnée, vide l'input
            }
        }*/
        populateOptionsContainer() {
            this.optionsContainer.innerHTML = ''; // Nettoyer les options précédentes
            const groups = Array.from(this.selectElement.children); // Récupérer tous les enfants (options et optgroups)

            groups.forEach(group => {
                if (group.tagName.toLowerCase() === 'optgroup') {
                    // Créer un conteneur pour le groupe
                    const groupContainer = document.createElement('div');
                    groupContainer.className = 'GBMNET_SELECT-optgroup';
                    groupContainer.dataset.label = group.label;

                    // Ajouter un titre pour l'optgroup
                    const groupLabel = document.createElement('div');
                    groupLabel.className = 'GBMNET_SELECT-optgroup-label';
                    groupLabel.textContent = group.label;
                    groupContainer.appendChild(groupLabel);

                    let hasVisibleOptions = false; // Pour vérifier si le groupe a des options visibles

                    // Ajouter les options de l'optgroup
                    Array.from(group.children).forEach(option => {
                        const computedStyle = window.getComputedStyle(option);
                        const isVisible = (option.dataset.visible === 'true' || option.dataset.visible === undefined)
                            && computedStyle.display !== 'none';

                        if (isVisible) {
                            hasVisibleOptions = true;
                            const optionItem = document.createElement('div');
                            optionItem.className = 'GBMNET_SELECT-option-item';
                            optionItem.textContent = option.textContent;
                            optionItem.dataset.value = option.value;

                            // Transférer les classes de l'option vers le div
                            if (option.className) {
                                option.classList.forEach(cls => {
                                    optionItem.classList.add(cls);
                                });
                            }

                            if (option.selected) {
                                const visibleText = option.dataset.visibleText || option.textContent;
                                this.searchInput.value = visibleText;
                                optionItem.classList.add('selected');
                            }

                            groupContainer.appendChild(optionItem);
                        }
                    });

                    // N'ajouter le groupe que s'il contient des options visibles
                    if (hasVisibleOptions) {
                        this.optionsContainer.appendChild(groupContainer);
                    }
                } else if (group.tagName.toLowerCase() === 'option') {
                    // Cas où l'option est directement dans le select (pas dans un optgroup)
                    const computedStyle = window.getComputedStyle(group);
                    const isVisible = (group.dataset.visible === 'true' || group.dataset.visible === undefined)
                        && computedStyle.display !== 'none';

                    if (isVisible) {
                        const optionItem = document.createElement('div');
                        optionItem.className = 'GBMNET_SELECT-option-item';
                        optionItem.textContent = group.textContent;
                        optionItem.dataset.value = group.value;

                        // Transférer les classes de l'option vers le div
                        if (group.className) {
                            group.classList.forEach(cls => {
                                optionItem.classList.add(cls);
                            });
                        }

                        // Rapatrier les styles de l'option
                        if (group.getAttribute('style')) {
                            optionItem.setAttribute('style', group.getAttribute('style'));
                        }
                        optionItem.style.backgroundColor = computedStyle.backgroundColor;
                        optionItem.style.color = computedStyle.color;
                        optionItem.style.fontWeight = computedStyle.fontWeight;

                        if (group.selected) {
                            const visibleText = group.dataset.visibleText || group.textContent;
                            this.searchInput.value = visibleText;
                            optionItem.classList.add('selected');
                        }

                        this.optionsContainer.appendChild(optionItem);
                    }
                }
            });

            // Gestion de l'option sélectionnée (si aucune n'est sélectionnée)
            const selectedOption = this.selectElement.options[this.selectElement.selectedIndex];
            if (selectedOption) {
                const visibleText = selectedOption.dataset.visibleText || selectedOption.textContent;
                this.searchInput.value = visibleText;
            } else {
                this.searchInput.value = ''; // Si aucune option sélectionnée, vide l'input
            }
        }



        selectOption(optionItem) {
            const selectedOption = Array.from(this.selectElement.options).find(option => option.value === optionItem.dataset.value);
            selectedOption.selected = true;
            this.selectElement.value = optionItem.dataset.value;

            const visibleText = selectedOption.dataset.visibleText || selectedOption.textContent;
            this.searchInput.value = visibleText;

            this.hideSearch();

            // if (typeof this.selectElement.onchange === 'function') {
            //     this.selectElement.onchange();
            // }
            $(this.selectElement).trigger('change');
        }

        addEventListeners() {
            /*this.searchInput.addEventListener('click', () => this.showSearch());
            this.searchInput.addEventListener('focus', () => this.showSearch());
            this.chevron.addEventListener('click', () => this.toggleSearch());*/
            this.searchInput.addEventListener('click', (event) => {
                event.preventDefault();
                this.showSearch();

            });

            this.searchInput.addEventListener('focus', (event) => {
                event.preventDefault();
                if (event.relatedTarget) { // pour ne pas ouvrir le select quand c'est Firefox qui fait le focus sur le 1er select
                    this.showSearch();
                }
            });

            this.selectElement.addEventListener('change', (event) => {
                console.log("sa chie !");
                event.preventDefault();
                this.updateFromSelect();
            });

            this.chevron.addEventListener('click', (event) => {
                event.preventDefault();
                if (this.active) {
                    this.hideSearch();
                } else {
                    this.showSearch();
                }
            });

            this.searchInput.addEventListener('input', () => {
                const filter = this.searchInput.value.toLowerCase().trim();
                Array.from(this.optionsContainer.children).forEach(optionItem => {
                    const text = optionItem.textContent.toLowerCase();
                    optionItem.style.display = text.includes(filter) ? 'block' : 'none';
                });
            });

            this.optionsContainer.addEventListener('click', (event) => {
                if (event.target.classList.contains('GBMNET_SELECT-option-item')) {
                    this.selectOption(event.target);
                }
            });

            document.addEventListener('click', this.documentClickHandler.bind(this));

            this.searchInput.addEventListener('keydown', (event) => {
                let visibleOptions = Array.from(this.optionsContainer.querySelectorAll('.GBMNET_SELECT-option-item'))
                    .filter(option => option.style.display !== 'none'); // Ne garder que les options visibles
                let highlightedIndex = visibleOptions.findIndex(option => option.classList.contains('highlighted'));


                switch (event.key) {
                    case 'ArrowDown':
                        event.preventDefault();

                        if (this.active == false)
                            this.showSearch();

                        if (highlightedIndex !== -1) {
                            visibleOptions[highlightedIndex].classList.remove('highlighted');
                        }
                        highlightedIndex = (highlightedIndex + 1) % visibleOptions.length; // Aller à l'option suivante
                        visibleOptions[highlightedIndex].classList.add('highlighted');
                        break;

                    case 'ArrowUp':
                        event.preventDefault();

                        if (highlightedIndex !== -1) {
                            visibleOptions[highlightedIndex].classList.remove('highlighted');
                        }
                        highlightedIndex = (highlightedIndex - 1 + visibleOptions.length) % visibleOptions.length; // Aller à l'option précédente
                        visibleOptions[highlightedIndex].classList.add('highlighted');
                        break;

                    case 'Enter':
                        event.preventDefault();

                        if (highlightedIndex !== -1) {
                            this.selectOption(visibleOptions[highlightedIndex]); // Sélectionner l'option en surbrillance
                        }
                        break;

                    case 'Escape':
                        if (this.active) event.preventDefault(); // Empêcher la fermeture de la fenêtre que si elle est ouverte
                        this.hideSearch();
                        break;

                    case 'Tab':
                        if (highlightedIndex !== -1) {
                            this.selectOption(visibleOptions[highlightedIndex]); // Sélectionner l'option en surbrillance
                        }
                        this.hideSearch();
                        break;
                }
            });
        }



        updateFromSelect() {
            const selectedOption = this.selectElement.options[this.selectElement.selectedIndex];
            if (selectedOption) {
                const visibleText = selectedOption.dataset.visibleText || selectedOption.textContent;
                this.searchInput.value = visibleText;
                this.populateOptionsContainer(); // Mettre à jour les options affichées
            } else {
                this.searchInput.value = '';
            }
        }

        documentClickHandler(event) {
            if (!this.selectElement.contains(event.target) &&
                !this.searchInput.contains(event.target) &&
                !this.chevron.contains(event.target) &&
                !this.optionsContainer.contains(event.target)) {
                this.hideSearch();
            }
        }

        showSearch() {
            // Positionner le conteneur d'options juste en dessous de l'input de recherche
            $(this.optionsContainer).css({
                'top': $(this.searchInput).offset().top + $(this.searchInput).outerHeight(),
                'left': $(this.searchInput).offset().left,
                'max-width': $(window).width() - $(this.searchInput).offset().left - 20,
            });
            this.active = true;
            this.container.classList.add('active');
            this.populateOptionsContainer();
            this.optionsContainer.style.display = 'block';
            this.searchInput.focus();
            this.searchInput.select(); // sélectionner le texte quand on l'ouvre



            /*document.querySelectorAll('.GBMNET_SELECT-options-container').forEach(container => {
                const parent = container.closest('.GBMNET_SELECT-container');
                const rect = parent.getBoundingClientRect();

                container.style.top = `${rect.bottom}px`;
                container.style.left = `${rect.left}px`;
                //container.style.width = `${rect.width}px`;
            });*/


        }

        hideSearch() {
            this.active = false;
            this.container.classList.remove('active');
            this.optionsContainer.style.display = 'none';
            if (this.selectElement.options[this.selectElement.selectedIndex]) {
                this.searchInput.value = this.selectElement.options[this.selectElement.selectedIndex].textContent;
            }
        }

        toggleSearch() {
            if (this.active) {
                this.hideSearch();
            } else {
                this.showSearch();
            }
        }

        destroy() {
            document.removeEventListener('click', this.documentClickHandler.bind(this));

            // Retirer les éléments créés (input de recherche et conteneur d'options)
            this.searchInput.remove();
            this.optionsContainer.remove();
            this.chevron.remove();
            this.selectElement.style.display = 'block';
        }
    }
})(jQuery);
