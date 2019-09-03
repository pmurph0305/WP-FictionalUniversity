import $ from 'jquery';

class LiveSearch {
  // 1. Describe and create/initiate our object.
  constructor() {
    this.addSearchHTML();

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
  addSearchHTML() {
    $("body").append(`
    <div class="search-overlay">
      <div class="search-overlay__top">
        <div class="container">
          <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
          <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
          <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
        </div>
      </div>
      <div class="container">
        <div id="search-overlay__results">
        </div>
      </div>
    </div>
    `)
  }

  closeOverlay() {
    this.isOverlayOpen = false;
    this.searchOverlay.removeClass('search-overlay--active');
    $("body").removeClass("body-no-scroll");
  }

  getSearchResults() {
    $.when(
      $.getJSON(universityData.rootUrl + "/wp-json/wp/v2/posts?search=" + this.searchField.val()), 
      $.getJSON(universityData.rootUrl + "/wp-json/wp/v2/pages?search=" + this.searchField.val())
    ).then((posts, pages) => {
      let results = posts[0].concat(pages[0]);
        this.searchResultsDiv.html(`
        <h2 class="search-overlay__section-title">General Info</h2>
        ${results.length ? '<ul class="link-list min-list">' : '<p>No results found.</p>'}
          ${results.map(result => `<li><a href="${result.link}">${result.title.rendered}</a> ${result.authorName ? `by ${result.authorName}` : ""}</li>`).join('')}
          ${results.length ? '</ul>' : ''}
      `)
      this.isLoadingSpinnerDisplayed = false;
    }, () => {
      this.searchResultsDiv.html(`<p>Unexpected error, please try again.</p>`);
    })
  }

  handleSearchTyping(e) {
    if (this.searchField.val() !== this.previousValue) {
      clearTimeout(this.searchTimeout);
      if (this.searchField.val()) {
        if (!this.isLoadingSpinnerDisplayed) {
          this.isLoadingSpinnerDisplayed = true;
          this.searchResultsDiv.html('<div class="spinner-loader"></div>');
        }
        this.searchTimeout = setTimeout(this.getSearchResults.bind(this), 500);
      } else {
        this.isLoadingSpinnerDisplayed = false;
        this.searchResultsDiv.html('');
      }
    }
    this.previousValue = this.searchField.val();
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
    this.searchField.val("");
    this.searchOverlay.addClass('search-overlay--active');
    $("body").addClass("body-no-scroll");
    setTimeout(() => this.searchField.focus(), 301);
  }
} 

export default LiveSearch;