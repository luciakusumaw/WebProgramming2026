# User Flow: Searching Overdue Member Loans

## Flow 3: Searching for Members with Overdue Loans (Librarian Actor)
```text
[Dashboard: SIMPUS-Mini]
       │
       ▼
[Click "Members" or "Loan Management" Menu]
       │
       ▼
[Display Members / Loans Management Page]
       │
       ▼
[Apply Filter: Set Status to "Overdue" / Past Due Date]
       │
       ▼
[Click "Search" / "Filter" Button]
       │
       ▼
  < Any Overdue Records Found? >
       ├─────────────────────────[No / Zero Records]───────────┐
       │                                                       ▼
       │ (Yes / Records Found)                       [Display Empty State]
       ▼                                         ("No overdue records found")
[Display Filtered Table:                                       │
 Member ID, Name, Book Title, Due Date, Days Late, Fine]       │
       │                                                       │
       ▼                                                       │
[Librarian Selects Action:                                     │
 - Click "Send Reminder Notification"                          │
 - Click "View Member Details / Contact"]                      │
       │                                                       │
       ▼                                                       │
[Notification Dispatched / Member Profile Displayed] ◄─────────┘
       │
       ▼
[End: Overdue Task Resolved]
```