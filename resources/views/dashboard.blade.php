
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<div class="container mt-5">

    
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">
            + Add Task
        </button>
    </div>
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
  
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{url('/task/store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                       
                        <div class="mb-3">
                            <label for="title" class="form-label">Task Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Task Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<div class="container mt-4">

    <h4 class="mb-3">Task List</h4>

 
   <ul class="nav nav-tabs mb-3" id="taskTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active text-white" id="all-tab" data-bs-toggle="tab" data-bs-target="#allTasksTab" type="button" role="tab" style="background-color: #0d6efd;">
            All Tasks
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-white" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completedTasksTab" type="button" role="tab" style="background-color: #198754;">
            Completed Tasks
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-white" id="incomplete-tab" data-bs-toggle="tab" data-bs-target="#incompleteTasksTab" type="button" role="tab" style="background-color: #ffc107;">
            Incomplete Tasks
        </button>
    </li>
</ul>


   
    <div class="tab-content" id="taskTabContent">

    
       <div class="tab-pane fade show active" id="allTasksTab" role="tabpanel">
    <table class="table table-bordered table-striped shadow-sm" id="allTasksTable">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allTasks as $task)
            <tr data-id="{{ $task->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>
                    @if($task->completed)
                        <span class="badge bg-success">Completed</span>
                    @else
                        <span class="badge bg-warning text-dark">Incomplete</span>
                    @endif
                </td>
                <td>
                    @if($task->completed)
                        <button class="btn btn-sm btn-success toggleBtn" data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-status="incomplete" data-bs-toggle="modal" data-bs-target="#toggleModal">Completed</button>
                    @else
                        <button class="btn btn-sm btn-warning toggleBtn" data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-status="completed" data-bs-toggle="modal" data-bs-target="#toggleModal">Incomplete</button>
                    @endif

                    <button class="btn btn-sm btn-primary me-2 editBtn" data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-description="{{ $task->description }}" data-bs-toggle="modal" data-bs-target="#editTaskModal">Edit</button>

                    <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


       
        <div class="tab-pane fade" id="completedTasksTab" role="tabpanel">
            <table class="table table-bordered table-striped shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedTasks as $task)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>
                            <button class="btn btn-sm btn-success toggleBtn" data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-status="incomplete" data-bs-toggle="modal" data-bs-target="#toggleModal">Completed</button>
                            <button class="btn btn-sm btn-primary me-2 editBtn" data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-description="{{ $task->description }}" data-bs-toggle="modal" data-bs-target="#editTaskModal">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

       
        <div class="tab-pane fade" id="incompleteTasksTab" role="tabpanel">
            <table class="table table-bordered table-striped shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incompleteTasks as $task)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning toggleBtn" data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-status="completed" data-bs-toggle="modal" data-bs-target="#toggleModal">Incomplete</button>
                            <button class="btn btn-sm btn-primary me-2 editBtn" data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-description="{{ $task->description }}" data-bs-toggle="modal" data-bs-target="#editTaskModal">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>


<div class="modal fade" id="toggleModal" tabindex="-1" aria-labelledby="toggleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="toggleForm" method="GET"> 
                <div class="modal-header">
                    <h5 class="modal-title" id="toggleModalLabel">Confirm Status Change</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to mark task: <strong id="toggleTaskTitle"></strong> as <span id="toggleStatusText"></span>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this task: <strong id="deleteTaskTitle"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(function() {
    // Make tbody sortable
    $("#allTasksTable tbody").sortable({
        placeholder: "ui-state-highlight",
        update: function(event, ui) {
            let order = [];
            $("#allTasksTable tbody tr").each(function(index){
                order.push($(this).data('id'));
            });

            $.ajax({
                url: "{{ route('tasks.reorder') }}",
                method: "POST",
                data: {
                    order: order,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response){
                    if(response.status === 'success'){
                        console.log('Tasks reordered successfully');
                    }
                }
            });
        }
    }).disableSelection();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var deleteButtons = document.querySelectorAll('.deleteBtn');
    var deleteForm = document.getElementById('deleteForm');
    var deleteTaskTitle = document.getElementById('deleteTaskTitle');

    deleteButtons.forEach(function(btn){
        btn.addEventListener('click', function(){
            var id = this.getAttribute('data-id');
            var title = this.getAttribute('data-title');

            deleteTaskTitle.textContent = title; 
            deleteForm.action = '/task/delete/' + id; 
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var toggleButtons = document.querySelectorAll('.toggleBtn');
    var toggleForm = document.getElementById('toggleForm');
    var toggleTaskTitle = document.getElementById('toggleTaskTitle');
    var toggleStatusText = document.getElementById('toggleStatusText');

    toggleButtons.forEach(function(btn){
        btn.addEventListener('click', function(){
            var id = this.getAttribute('data-id');
            var title = this.getAttribute('data-title');
            var status = this.getAttribute('data-status');

            toggleTaskTitle.textContent = title;
            toggleStatusText.textContent = status;

            toggleForm.action = '/task/toggle/' + id; 
        });
    });
});
</script>

<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var editButtons = document.querySelectorAll('.editBtn');
    editButtons.forEach(function(button){
        button.addEventListener('click', function(){
            var id = this.getAttribute('data-id');
            var title = this.getAttribute('data-title');
            var description = this.getAttribute('data-description');

            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;

          
            document.getElementById('editForm').action = '/task/update/' + id;
        });
    });
});
</script>