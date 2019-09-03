import $ from 'jquery';

class LiveSearch {
  // 1. Describe and create/initiate our object.
  constructor() {
    this.closeButton = $(".search-overlay__close");
    this.openButton = $(".js-search-trigger");
  
    this.searchOverlay = $(".search-overlay");
    this.searchResultsDiv = $("#search-overlay__results");
    this.searchField = $("#search-term");

    this.isOverlayOpen = false;
    this.isLoadingSpinnerDisplayed = false;
    this.searchTimeout;
    this.previousValue;
    
    this.events();
  }

  // 2. events
  events() {
    this.closeButton.on('click', this.closeOverlay.bind(this));
    this.openButton.on('click', this.openOverlay.bind(this));
    this.searchField.on("keyup", this.handleSearchTyping.bind(this));

    $(document).on("keydown", this.keyPressDispatcher.bind(this));
  }


  // 3. methods
  closeOverlay() {
    this.isOverlayOpen = false;
    this.searchOverlay.removeClass('search-overlay--active');
    $("body").removeClass("body-no-scroll");
  }
  
  keyPressDispatcher(e) {
    if (e.keyCode === 83 && !this.isOverlayOpen && !$('input, textarea').is(':focus')) { 
      this.openOverlay();
    } else if (e.keyCode === 27 && this.isOverlayOpen) {      
      this.closeOverlay();
    }
  }

  openOverlay() {
    this.isOverlayOpen = true;
    this.searchOverlay.addClass('search-overlay--active');
    $("body").addClass("body-no-scroll");
  }

  handleSearchTyping(e) {
    if (this.searchField.val() !== this.previousValue) {
      clearTimeout(this.searchTimeout);
      if (this.searchField.val()) {
        if (!this.isLoadingSpinnerDisplayed) {
          this.isLoadingSpinnerDisplayed = true;
          this.searchResultsDiv.html('<div class="spinner-loader"></div>');
        }
        this.searchTimeout = setTimeout(this.getSearchResults.bind(this), 1000);
      } else {
        this.isLoadingSpinnerDisplayed = false;
        this.searchResultsDiv.html('');
      }
    }
    this.previousValue = this.searchField.val();
  }

  getSearchResults() {
    this.isLoadingSpinnerDisplayed = false;
    this.searchResultsDiv.html("example")
  }

} 

export default LiveSearch;