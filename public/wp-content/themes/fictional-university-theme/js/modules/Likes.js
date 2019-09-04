import $ from 'jquery';

class Likes {
  constructor() {
    this.events();
  }

  events() {
    $(".like-box").on("click", this.onLikeClick.bind(this));
  }

  onLikeClick(e) {
    let currentLikeBox = $(e.target).closest('.like-box')
    if (currentLikeBox.attr('data-exists') === 'yes') {
      this.removeLike(currentLikeBox);
    } else {
      this.addLike(currentLikeBox);
    }
  }

  addLike(likeBox) {
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.rootUrl + '/wp-json/university/v1/like',
      type: 'POST',
      data: {
        'professorId': likeBox.attr('data-professor-id')
      },
      success: (response) => {
        likeBox.attr('data-exists', 'yes');
        likeBox.attr('data-like-id', response);
        let likes = parseInt(likeBox.find('.like-count').html(), 10);
        likes += 1;
        likeBox.find('.like-count').html(likes);
        console.log('add like response', response);
      },
      error: (response) => {
        console.log('add like error', response);
      }
    });
  }

  removeLike(likeBox) {
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.rootUrl + '/wp-json/university/v1/like',
      type: 'DELETE',
      data: {
        'likeId': likeBox.attr('data-like-id')
      },
      success: (response) => {
        likeBox.attr('data-exists', 'no');
        likeBox.attr('data-like-id', '')
        let likes = parseInt(likeBox.find('.like-count').html(), 10);
        likes -= 1;
        likeBox.find('.like-count').html(likes);
        console.log('delete like response', response);
      },
      error: (response) => {
        console.log('delete like error', response);
      }
    });
  }

}

export default Likes;