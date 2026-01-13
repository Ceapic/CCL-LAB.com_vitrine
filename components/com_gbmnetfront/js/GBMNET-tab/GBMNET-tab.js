/**
 * TabSystem adapté pour l'application existante
 * Compatible avec la structure HTML de index.php
 * @author GBMNet
 * @version 3.0 - Application Compatible
 */

(function() {
    'use strict';

    /**
     * TabSystem pour l'application existante
     * Utilise la structure: #top.tabs avec a[data-tab] et #contenu avec .tabcontent
     */
    window.TabSystem = function(containerSelector, options) {
        // Configuration par défaut
        var defaults = {
            activeClass: 'active',
            animation: true,
            animationDuration: 300,
            defaultTab: 0,
            onTabChange: null,
            onBeforeTabChange: null,
            onAfterTabChange: null
        };

        // Fusionner les options
        this.options = $.extend({}, defaults, options);
        
        // Déterminer les conteneurs selon le sélecteur
        if (containerSelector === '#top' || containerSelector === '.tabs' || containerSelector === '#top.tabs') {
            // Structure application existante (onglets principaux)
            this.$tabContainer = $('#top.tabs');
            this.$contentContainer = $('#contenu');
            this.$tabs = this.$tabContainer.find('a[data-tab]');
            this.$contents = this.$contentContainer.find('.tabcontent');
        } else {
            // Structure générique ou spécialisée
            this.$container = $(containerSelector);
            
            // Vérifier s'il y a des sous-conteneurs spécifiques
            var $tabHeader = this.$container.find('.tab-header');
            var $contentContainer = this.$container.find('.tab-content-container');
            
            if ($tabHeader.length > 0 && $contentContainer.length > 0) {
                // Structure avec conteneurs séparés (comme #tab_fournisseurs)
                this.$tabContainer = this.$container;
                this.$contentContainer = this.$container;
                this.$tabs = $tabHeader.find('.tab-button');
                this.$contents = $contentContainer.find('.tab-content');
                console.log('Structure avec conteneurs séparés détectée');
            } else {
                // Structure générique simple
                this.$tabs = this.$container.find('.tab-button');
                this.$contents = this.$container.find('.tab-content');
                
                // Si pas de .tab-button, essayer a[data-tab]
                if (this.$tabs.length === 0) {
                    this.$tabs = this.$container.find('a[data-tab]');
                    this.$contents = this.$container.find('.tabcontent');
                }
            }
        }

        this.activeTabIndex = -1;
        this.isAnimating = false;

        // Initialisation
        this.init();
        
        return this;
    };

    // Méthodes du prototype
    window.TabSystem.prototype = {
        /**
         * Initialisation
         */
        init: function() {
            this.bindEvents();
            this.setActiveTab(this.options.defaultTab);
        },

        /**
         * Liaison des événements
         */
        bindEvents: function() {
            var self = this;

            // Supprimer les anciens événements
            this.$tabs.off('.tabsystem');

            // Événements de clic
            this.$tabs.on('click.tabsystem', function(e) {
                e.preventDefault();
                if (self.isAnimating) return;
                
                var index = self.$tabs.index($(this));
                self.setActiveTab(index);
            });

            // Support clavier
            this.$tabs.on('keydown.tabsystem', function(e) {
                if (self.isAnimating) return;
                
                switch(e.which) {
                    case 13: // Enter
                    case 32: // Space
                        e.preventDefault();
                        var index = self.$tabs.index($(this));
                        self.setActiveTab(index);
                        break;
                    case 37: // Left arrow
                        e.preventDefault();
                        self.previousTab();
                        break;
                    case 39: // Right arrow
                        e.preventDefault();
                        self.nextTab();
                        break;
                }
            });

            // Rendre focusables
            this.$tabs.attr('tabindex', '0');
        },

        /**
         * Active un onglet spécifique
         */
        setActiveTab: function(index) {
            if (index < 0 || index >= this.$tabs.length || this.isAnimating) {
                return false;
            }

            var previousIndex = this.activeTabIndex;
            var $newTab = this.$tabs.eq(index);
            var $newContent = this.$contents.eq(index);

            // Vérifier si l'onglet est désactivé
            if ($newTab.hasClass('disabled')) {
                return false;
            }

            // Callback avant changement
            if (typeof this.options.onBeforeTabChange === 'function') {
                var result = this.options.onBeforeTabChange.call(this, index, previousIndex, {
                    tab: $newTab[0],
                    content: $newContent[0]
                });
                
                if (result === false) {
                    return false;
                }
            }

            this.activeTabIndex = index;
            
            if (this.options.animation) {
                this.isAnimating = true;
            }

            // Désactiver tous les onglets
            this.$tabs.removeClass(this.options.activeClass);
            this.$contents.removeClass(this.options.activeClass);
            
            // Activer l'onglet sélectionné
            $newTab.addClass(this.options.activeClass);

            // Gestion du contenu
            if (this.options.animation) {
                this.animateContent($newContent);
            } else {
                this.showContent($newContent);
            }

            // Focus sur l'onglet actif
            $newTab.focus();

            // Callback pendant le changement
            if (typeof this.options.onTabChange === 'function') {
                this.options.onTabChange.call(this, index, previousIndex, {
                    tab: $newTab[0],
                    content: $newContent[0]
                });
            }

            // Émettre un événement
            $(document).trigger('tabSystem:changed', {
                activeIndex: index,
                previousIndex: previousIndex,
                tab: $newTab[0],
                content: $newContent[0]
            });

            return true;
        },

        /**
         * Affichage sans animation
         */
        showContent: function($content) {
            this.$contents.hide();
            $content.addClass(this.options.activeClass).show();
            this.onAnimationComplete();
        },

        /**
         * Animation du contenu
         */
        animateContent: function($newContent) {
            var self = this;
            
            // Masquer tous les contenus
            this.$contents.not($newContent).fadeOut(200);
            
            // Afficher le nouveau contenu
            $newContent.addClass(this.options.activeClass)
                      .fadeIn(this.options.animationDuration, function() {
                          self.onAnimationComplete();
                      });
        },

        /**
         * Fin d'animation
         */
        onAnimationComplete: function() {
            this.isAnimating = false;
            
            if (typeof this.options.onAfterTabChange === 'function') {
                var $activeTab = this.$tabs.eq(this.activeTabIndex);
                var $activeContent = this.$contents.eq(this.activeTabIndex);
                
                this.options.onAfterTabChange.call(this, this.activeTabIndex, {
                    tab: $activeTab[0],
                    content: $activeContent[0]
                });
            }
        },

        /**
         * Onglet suivant
         */
        nextTab: function() {
            if (this.isAnimating) return false;
            var nextIndex = (this.activeTabIndex + 1) % this.$tabs.length;
            return this.setActiveTab(nextIndex);
        },

        /**
         * Onglet précédent
         */
        previousTab: function() {
            if (this.isAnimating) return false;
            var prevIndex = this.activeTabIndex === 0 ? this.$tabs.length - 1 : this.activeTabIndex - 1;
            return this.setActiveTab(prevIndex);
        },

        /**
         * Obtenir l'index actif
         */
        getActiveTabIndex: function() {
            return this.activeTabIndex;
        },

        /**
         * Obtenir l'onglet actif
         */
        getActiveTab: function() {
            return this.activeTabIndex >= 0 ? this.$tabs.eq(this.activeTabIndex) : $();
        },

        /**
         * Obtenir le contenu actif
         */
        getActiveContent: function() {
            return this.activeTabIndex >= 0 ? this.$contents.eq(this.activeTabIndex) : $();
        },

        /**
         * Désactiver/Activer un onglet
         */
        setTabDisabled: function(index, disabled) {
            if (index < 0 || index >= this.$tabs.length) {
                return false;
            }

            var $tab = this.$tabs.eq(index);
            
            if (disabled !== false) {
                $tab.addClass('disabled');
            } else {
                $tab.removeClass('disabled');
            }
            
            return true;
        },

        /**
         * Ajouter un onglet (compatible toutes structures)
         */
        addTab: function(tabText, contentHTML, position) {
            var tabIndex = position !== null && position !== undefined ? position : this.$tabs.length;
            var $newTab, $newContent;

            // Déterminer le type de structure et créer les éléments appropriés
            if (this.$tabContainer && this.$contentContainer) {
                // Structure avec conteneurs séparés (comme votre application)
                $newTab = $('<button>')
                    .addClass('tab-button')
                    .text(tabText)
                    .attr('tabindex', '0');

                $newContent = $('<div>')
                    .addClass('tab-content')
                    .html(contentHTML);

                // Insérer dans les conteneurs appropriés
                if (position !== null && position !== undefined && position < this.$tabs.length) {
                    this.$tabs.eq(position).before($newTab);
                    this.$contents.eq(position).before($newContent);
                } else {
                    this.$tabContainer.find('.tab-header').append($newTab);
                    this.$contentContainer.find('.tab-content-container').append($newContent);
                }
            } else if (this.$container) {
                // Structure générique dans un seul conteneur
                $newTab = $('<button>')
                    .addClass('tab-button')
                    .text(tabText)
                    .attr('tabindex', '0');

                $newContent = $('<div>')
                    .addClass('tab-content')
                    .html(contentHTML);

                // Insérer
                if (position !== null && position !== undefined && position < this.$tabs.length) {
                    this.$tabs.eq(position).before($newTab);
                    this.$contents.eq(position).before($newContent);
                } else {
                    var $tabContainer = this.$tabs.parent();
                    var $contentContainer = this.$contents.parent();
                    
                    $tabContainer.append($newTab);
                    $contentContainer.append($newContent);
                }
            } else {
                console.warn('Impossible d\'ajouter un onglet - structure non reconnue');
                return false;
            }

            // Rafraîchir les références
            if (this.$tabContainer && this.$contentContainer) {
                this.$tabs = this.$tabContainer.find('.tab-button');
                this.$contents = this.$contentContainer.find('.tab-content');
            } else {
                this.$tabs = this.$container.find('.tab-button');
                this.$contents = this.$container.find('.tab-content');
            }
            
            this.bindEvents();

            console.log('Onglet ajouté:', tabText, 'Total onglets:', this.$tabs.length);
            return true;
        },

        /**
         * Supprimer un onglet
         */
        removeTab: function(index) {
            if (index < 0 || index >= this.$tabs.length) {
                return false;
            }

            this.$tabs.eq(index).remove();
            this.$contents.eq(index).remove();

            // Rafraîchir
            if (this.$container) {
                this.$tabs = this.$container.find('.tab-button');
                this.$contents = this.$container.find('.tab-content');
            } else {
                this.$tabs = this.$tabContainer.find('a[data-tab]');
                this.$contents = this.$contentContainer.find('.tabcontent');
            }

            // Réactiver un onglet si nécessaire
            if (index === this.activeTabIndex && this.$tabs.length > 0) {
                this.activeTabIndex = -1;
                this.setActiveTab(0);
            }

            this.bindEvents();
            return true;
        },

        /**
         * Détruire l'instance
         */
        destroy: function() {
            this.$tabs.off('.tabsystem');
            this.$tabs.removeAttr('tabindex');
            this.$tabs.removeClass(this.options.activeClass + ' disabled');
            this.$contents.removeClass(this.options.activeClass);
            
            this.$tabs = null;
            this.$contents = null;
            this.$container = null;
            this.$tabContainer = null;
            this.$contentContainer = null;
        }
    };

})();

console.log('TabSystem compatible chargé et prêt !');