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
    $.getJSON(universityData.rootUrl + '/wp-json/university/v1/search?term=' + this.searchField.val(), (results) => {
      this.searchResultsDiv.html(`
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General Info</h2>
            ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No results found.</p>'}
            ${results.generalInfo.map(result => `<li><a href="${result.permalink}">${result.title}</a> ${result.postType === 'post' ? `by ${result.authorName}` : ""}</li>`).join('')}
            ${results.generalInfo.length ? '</ul>' : ''}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Programs</h2>
            ${results.programs.length ? '<ul class="link-list min-list">' : `<p>No programs found. <a href="${universityData.rootUrl}/programs">View all programs.</a></p>`}
            ${results.programs.map(result => `<li><a href="${result.permalink}">${result.title}</a></li>`).join('')}
            ${results.programs.length ? '</ul>' : ''}
            <h2 class="search-overlay__section-title">Professors</h2>
            ${results.professors.length ? '<ul class="professor-cards">' : `<p>No professors found.</p>`}
            ${results.professors.map(result => `
            <li class="professor-card__list-item">
                <a class="professor-card" href="${result.permalink}">
                  <img class="professor-card__image" src="${result.image}">
                  <span class="professor-card__name">${result.title}</span>
                </a>
            </li>
            `).join('')}
            ${results.professors.length ? '</ul>' : ''}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Events</h2>
            ${results.events.length ? '' :  `<p>No events found. <a href="${universityData.rootUrl}/events">View all events.</a></p>`}
            ${results.events.map(result => `
              <div class="event-summary">
              <a class="event-summary__date t-center" href="${result.permalink}">
                <span class="event-summary__month">${result.month}</span>
                <span class="event-summary__day">${result.day}</span>  
              </a>
              <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="${result.permalink}">${result.title}</a></h5>
                <p> ${result.description}
                  <a href="${result.permalink}" class="nu gray">Learn more</a>
                </p>
              </div>
            </div>
            `).join('')}
            <h2 class="search-overlay__section-title">Campuses</h2>
            ${results.campuses.length ? '<ul class="link-list min-list">' :  `<p>No campuses found. <a href="${universityData.rootUrl}/campuses">View all campuses.</a></p>`}
            ${results.campuses.map(result => `<li><a href="${result.permalink}">${result.title}</a></li>`).join('')}
            ${results.campuses.length ? '</ul>' : ''}
          </div>
        </div>
      
      
      `);
      this.isLoadingSpinnerDisplayed = false;
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