<?php

return [
    /*
     *  Constants
     */

    'nav-active-tickets' => 'Active Tickets',
    'nav-completed-tickets' => 'Completed Tickets',

    // Tables
    'table-id' => '#',
    'table-subject' => 'Subject',
    'table-owner' => 'Owner',
    'table-status' => 'Status',
    'table-last-updated' => 'Last Updated',
    'table-priority' => 'Priority',
    'table-agent' => 'Agent',
    'table-category' => 'Category',

    // Datatables
    'table-decimal' => '',
    'table-empty' => 'No data available in table',
    'table-info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
    'table-info-empty' => 'Showing 0 to 0 of 0 entries',
    'table-info-filtered' => '(filtered from _MAX_ total entries)',
    'table-info-postfix' => '',
    'table-thousands' => ',',
    'table-length-menu' => 'Show _MENU_ entries',
    'table-loading-results' => 'Loading...',
    'table-processing' => 'Processing...',
    'table-search' => 'Search:',
    'table-zero-records' => 'No matching records found',
    'table-paginate-first' => 'First',
    'table-paginate-last' => 'Last',
    'table-paginate-next' => 'Next',
    'table-paginate-prev' => 'Previous',
    'table-aria-sort-asc' => ': activate to sort column ascending',
    'table-aria-sort-desc' => ': activate to sort column descending',

    // Buttons
    'btn-back' => 'Back',
    'btn-cancel' => 'Cancel',
    'btn-close' => 'Close',
    'btn-delete' => 'Delete',
    'btn-edit' => 'Edit',
    'btn-mark-complete' => 'Mark Complete',
    'btn-submit' => 'Submit',
    'btn-create-ticket' => 'Create Ticket',
    'btn-create-new-ticket' => 'Create New Ticket',

    // General
    'agent' => 'Agent',
    'category' => 'Category',
    'colon' => ': ',
    'comments' => 'Comments',
    'created' => 'Created',
    'description' => 'Description',
    'flash-x' => '×',
    'last-update' => 'Last Update',
    'no-replies' => 'No replies.',
    'owner' => 'Owner',
    'priority' => 'Priority',
    'reopen-ticket' => 'Reopen Ticket',
    'reply' => 'Reply',
    'responsible' => 'Responsible',
    'status' => 'Status',
    'subject' => 'Subject',
    'message' => 'Message',

    // Select Options
    'select-category' => 'Select Category',
    'select-priority' => 'Select Priority',
    'select-status' => 'Select Status',

    /*
     *  Page specific
     */

    // Index
    'index-title' => 'Helpdesk main page',

    // Tickets
    'index-my-tickets' => 'My Tickets',
    'index-complete-none' => 'There are no complete tickets',
    'index-active-check' => 'Be sure to check Active Tickets if you cannot find your ticket.',
    'index-active-none' => 'There are no active tickets,',
    'index-create-new-ticket' => 'create new ticket',
    'index-complete-check' => 'Be sure to check Complete Tickets if you cannot find your ticket.',

    // Create Ticket
    'create-ticket' => 'Create Ticket',
    'create-ticket-title' => 'Create New Ticket Form',
    'create-ticket-brief-issue' => 'A brief summary of your issue',
    'create-ticket-describe-issue' => 'Describe your issue here in details',
    'create-new-ticket' => 'Create New Ticket',


    'index-empty-records' => 'No tickets found.',
    'index-my-tickets' => 'My Tickets',
    'btn-create-new-ticket' => 'Create New Ticket',

    

    // Show Ticket
    'show-ticket-title' => 'Ticket',
    'show-ticket-js-delete' => 'Are you sure you want to delete: ',
    'show-ticket-modal-delete-title' => 'Delete Ticket',
    'show-ticket-modal-delete-message' => 'Are you sure you want to delete ticket: :subject?',

    /*
     *  Controllers
     */

    // AgentsController
    'agents-are-added-to-agents' => 'Agents :names are added to agents',
    'administrators-are-added-to-administrators' => 'Administrators :names are added to administrators',
    'agents-joined-categories-ok' => 'Joined categories successfully',
    'agents-is-removed-from-team' => 'Removed agent\s :name from the agent team',
    'administrators-is-removed-from-team' => 'Removed administrator\s :name from the administrators team',

    // CategoriesController
    'category-name-has-been-created' => 'The category :name has been created!',
    'category-name-has-been-modified' => 'The category :name has been modified!',
    'category-name-has-been-deleted' => 'The category :name has been deleted!',

    // PrioritiesController
    'priority-name-has-been-created' => 'The priority :name has been created!',
    'priority-name-has-been-modified' => 'The priority :name has been modified!',
    'priority-name-has-been-deleted' => 'The priority :name has been deleted!',
    'priority-all-tickets-here' => 'All priority related tickets here',

    // StatusesController
    'status-name-has-been-created' => 'The status :name has been created!',
    'status-name-has-been-modified' => 'The status :name has been modified!',
    'status-name-has-been-deleted' => 'The status :name has been deleted!',
    'status-all-tickets-here' => 'All status related tickets here',

    // CommentsController
    'comment-has-been-added-ok' => 'Comment has been added successfully',

    // NotificationsController
    'notify-new-comment-from' => 'New comment from ',
    'notify-on' => ' on ',
    'notify-status-to-complete' => ' status to Complete',
    'notify-status-to' => ' status to ',
    'notify-transferred' => ' transferred ',
    'notify-to-you' => ' to you',
    'notify-created-ticket' => ' created ticket ',
    'notify-updated' => ' updated ',

    // TicketsController
    'the-ticket-has-been-created' => 'The ticket has been created!',
    'the-ticket-has-been-modified' => 'The ticket has been modified!',
    'the-ticket-has-been-deleted' => 'The ticket :name has been deleted!',
    'the-ticket-has-been-completed' => 'The ticket :name has been completed!',
    'the-ticket-has-been-reopened' => 'The ticket :name has been reopened!',
    'you-are-not-permitted-to-do-this' => 'You are not permitted to do this action!',

    /*
     *  Middlewares
     */

    //  IsAdminMiddleware IsAgentMiddleware ResAccessMiddleware
    'you-are-not-permitted-to-access' => 'You are not permitted to access this page!',

    /*
     * Email templates
     */
    'email-ticket-created-subject' => 'New Ticket Created',
    'email-ticket-updated-subject' => 'Ticket Updated',
    'email-ticket-closed-subject' => 'Ticket Closed',
    'email-comment-created-subject' => 'New Comment Added',

    /*
     * Validation messages
     */
    'validation' => [
        'subject' => [
            'required' => 'Subject is required',
            'min' => 'Subject must be at least :min characters'
        ],
        'content' => [
            'required' => 'Message content is required',
            'min' => 'Message must be at least :min characters'
        ],
        'category_id' => [
            'required' => 'Category is required',
            'exists' => 'Selected category does not exist'
        ],
        'priority_id' => [
            'required' => 'Priority is required',
            'exists' => 'Selected priority does not exist'
        ]
    ]
];