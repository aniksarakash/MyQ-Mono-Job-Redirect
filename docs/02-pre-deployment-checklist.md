# ☑️ Pre-deployment Checklist

Confirm all ten before touching anything. Items 3 to 5 are the ones engineers skip and then regret, because they are the values you need to mirror onto the new queue.

| # | Item | Done |
|---|---|:---:|
| 1 | MyQ licence valid, server running, no red banner | ☐ |
| 2 | Full database backup taken via Easy Config | ☐ |
| 3 | Exact printer list of `secure` recorded | ☐ |
| 4 | Rights list of `secure` recorded | ☐ |
| 5 | Job retention setting of `secure` recorded | ☐ |
| 6 | Ricoh IM 2500 online in MyQ | ☐ |
| 7 | Ricoh IM C2010 online in MyQ | ☐ |
| 8 | Confirmed whether MyQ Desktop Client is deployed | ☐ |
| 9 | Customer briefed on the content based limitation | ☐ |
| 10 | Change window agreed in writing | ☐ |

Item 9 points at [limitation 8.1](10-limitations.md). Brief it before deployment, not after the first user complaint.

---

## 🗺️ Full deployment map

```mermaid
flowchart TD
    subgraph P1["1️⃣ Server preparation"]
        A1[Clear licence error] --> A2[Database backup]
        A2 --> A3[Unlock PHP scripting]
        A3 --> A4[Enable Job Parser]
    end
    subgraph P2["2️⃣ Mono landing queue"]
        B1[Record secure config] --> B2[Add secure_mono]
        B2 --> B3[Printers, minus IM C2010]
        B3 --> B4[Copy rights]
        B4 --> B5[Match retention]
    end
    subgraph P3["3️⃣ Test mode"]
        C1["Paste script, ENFORCE = false"] --> C2[Confirm TEST MODE in Log]
    end
    subgraph P4["4️⃣ Monitor"]
        D1[3 to 5 working days] --> D2[Present the numbers]
        D2 --> D3{Customer approves?}
    end
    subgraph P5["5️⃣ Enforce"]
        E1["ENFORCE = true"] --> E2[Nine test acceptance plan]
    end
    subgraph P6["6️⃣ Close-out"]
        F1[Re-lock scripting] --> F2[Record the change]
        F2 --> F3[Handover]
    end

    P1 --> P2 --> P3 --> P4
    D3 -->|"yes"| P5 --> P6
    D3 -->|"no"| STOP["↩️ Clear the script<br/>zero downtime"]

    style P1 fill:#eff6ff,stroke:#2563eb
    style P2 fill:#f0fdf4,stroke:#16a34a
    style P3 fill:#faf5ff,stroke:#9333ea
    style P4 fill:#fffbeb,stroke:#d97706
    style P5 fill:#fef2f2,stroke:#dc2626
    style P6 fill:#f8fafc,stroke:#64748b
    style STOP fill:#f1f5f9,stroke:#475569
```

---

*Next: [Phase 1, server preparation](03-phase-1-server-preparation.md)*
