const assignmentButton = document.getElementById('assignmentButton');
const assignmentForm = document.getElementById('assignmentForm');
const cancelAssignment = document.getElementById('cancelAssignment');

assignmentButton?.addEventListener('click', () => {
    assignmentForm?.classList.toggle('hidden');
});

cancelAssignment?.addEventListener('click', () => {
    assignmentForm?.classList.add('hidden');
});

const priorityButton = document.getElementById('priorityButton');
const priorityForm = document.getElementById('priorityForm');
const cancelPriority = document.getElementById('cancelPriority');

priorityButton?.addEventListener('click', () => {
    priorityForm?.classList.toggle('hidden');
});

cancelPriority?.addEventListener('click', () => {
    priorityForm?.classList.add('hidden');
});