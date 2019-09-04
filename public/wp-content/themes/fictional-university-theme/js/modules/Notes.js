import $ from 'jquery';

class Notes {
  constructor() {
    this.events();
  }

  events() {
    $("#my-notes").on("click", ".delete-note", this.onDeleteNote);
    $("#my-notes").on("click", ".edit-note", this.onEditNote.bind(this));
    $("#my-notes").on("click", ".update-note", this.onUpdateNote.bind(this));
    $(".submit-note").on("click", this.onSubmitNote.bind(this));
  }

  // custom methods
  onDeleteNote(e) {
    var note = $(e.target).parents("li");
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.rootUrl + '/wp-json/wp/v2/note/' + note.data('id'),
      type: 'DELETE',
      success: (response) => {
        console.log("Deletion successful");
        console.log(response);
        note.slideUp();
        if (response.userNoteCount < 5) {
          $('.note-limit-message').removeClass("active");
        }
      },
      error: (response) => {
        console.log('Error deleting.');
        console.log(response);
      },
    });
  }

  onEditNote(e) {
    var note = $(e.target).parents("li");
    if (note.data("state") == "editable") {
      this.makeNoteReadOnly(note);
    } else {
      this.makeNoteEditable(note);
    }
  }

  onSubmitNote(e) {
    var newPost = {
      'title': $('.new-note-title').val(),
      'content': $('.new-note-body').val(),
      'status': 'publish'
    };
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.rootUrl + '/wp-json/wp/v2/note/',
      type: 'POST',
      data: newPost,
      success: (response) => {
        console.log(response);
        $(".new-note-title, .new-note-body").val('');
        $(`
        <li data-id="${response.id}">
          <input readonly class="note-title-field" value="${response.title.raw}">
          <span class="edit-note"><i class="fa fa-pencil" area-hidden="true"></i> Edit</span>
          <span class="delete-note"><i class="fa fa-trash-o" area-hidden="true"></i> Delete</span>
          <textarea readonly class="note-body-field">${response.content.raw}</textarea>
          <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" area-hidden="true"></i> Save</span>
        </li>
        `).prependTo("#my-notes").hide().slideDown();
      },
      error: (response) => {
        if (response.responseText === 'You have reached your maximum note limit.') {
          $('.note-limit-message').addClass("active");
        }
        console.log('Error updating.');
        console.log(response);
      },
    });
  }

  onUpdateNote(e) {
    var note = $(e.target).parents("li");
    var updateData = {
      'title': note.find('.note-title-field').val(),
      'content': note.find('.note-body-field').val(),
    }
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.rootUrl + '/wp-json/wp/v2/note/' + note.data('id'),
      type: 'POST',
      data: updateData,
      success: (response) => {
        console.log("Update successful");
        console.log(response);
        this.makeNoteReadOnly(note);
      },
      error: (response) => {
        console.log('Error updating.');
        console.log(response);
      },
    });
  }

  makeNoteEditable(note) {
    note.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
    note.find(".edit-note").html('<i class="fa fa-times" area-hidden="true"></i> Cancel')
    note.find(".update-note").addClass("update-note--visible");
    note.data("state", "editable");
  }

  makeNoteReadOnly(note) {
    note.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
    note.find(".edit-note").html('<i class="fa fa-pencil" area-hidden="true"></i> Edit')
    note.find(".update-note").removeClass("update-note--visible");
    note.data("state", "");
  }

}

export default Notes;