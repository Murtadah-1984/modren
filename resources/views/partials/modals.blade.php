<!-- Placeholder for modals -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h1 class="modal-title fs-5" id="eventModalLabel">New event</h1>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-4">
                        <label class="form-label" for="eventTitle">Title</label>
                        <input class="form-control" id="eventTitle" type="text" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="eventDescription">Description</label>
                        <textarea class="form-control" id="eventDescription" rows="3" data-autosize></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-4">
                                <label class="form-label" for="eventStart">Start</label>
                                <input class="form-control" id="eventStart" type="text" data-flatpickr />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-4">
                                <label class="form-label" for="eventEnd">End</label>
                                <input class="form-control" id="eventEnd" type="text" data-flatpickr />
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary w-100 mt-4">Create event</button>
                </form>
            </div>
        </div>
    </div>
</div>
