const assignmentButton = document.getElementById('assignmentButton');
const assignmentForm = document.getElementById('assignmentForm');
const cancelAssignment = document.getElementById('cancelAssignment');

assignmentButton?.addEventListener('click', () => {
    assignmentForm?.classList.toggle('hidden');
});

cancelAssignment?.addEventListener('click', () => {
    assignmentForm?.classList.add('hidden');
});