# 📐 Objective and Design

## 1. Objective

The Ricoh IM C2010 must be reserved for colour documents. Any job with no colour pages must not be releasable on that device, and must not be deleted. The user collects it from any other printer instead.

**Constraint:** the customer has too many users to touch PCs. Everything must be done inside MyQ.

---

## 2. Design

Users already print to a single Pull Print queue called `secure`. A printer can belong to more than one MyQ queue. That single fact is what makes this possible without touching a PC.

| Queue | Printers | Role |
|---|---|---|
| `secure` | **Unchanged.** Everything it contains today, including the IM C2010 | Users keep printing here |
| `secure_mono` | **The same list, minus the IM C2010** | Internal landing queue, never printed to directly |

A script on `secure` moves any job with no colour pages into `secure_mono`.

```mermaid
flowchart LR
    U["👤 User PC<br/><i>unchanged driver,<br/>unchanged share</i>"]
    Q1[("📥 <b>secure</b><br/>Pull Print")]
    JP{"🔍 Job Parser<br/>reads rendered pages"}
    Q2[("📥 <b>secure_mono</b><br/>Pull Print")]
    C["🖨️ Whole fleet<br/><b>including</b> IM C2010"]
    M["🖨️ Whole fleet<br/><b>except</b> IM C2010"]

    U -->|"prints to the secure share"| Q1
    Q1 --> JP
    JP -->|"has colour pages"| Q1
    JP -->|"zero colour pages<br/>moveToQueue()"| Q2
    Q1 -.->|"releasable at"| C
    Q2 -.->|"releasable at"| M

    style U fill:#e0e7ff,stroke:#4f46e5,color:#312e81
    style Q1 fill:#dbeafe,stroke:#2563eb,color:#1e3a8a
    style Q2 fill:#dcfce7,stroke:#16a34a,color:#14532d
    style JP fill:#fef3c7,stroke:#d97706,color:#78350f
    style C fill:#fce7f3,stroke:#db2777,color:#831843
    style M fill:#f1f5f9,stroke:#64748b,color:#0f172a
```

### Why this design

| ✅ | Property | Detail |
|:---:|---|---|
| 🚫 | **Zero client side work** | Same share, same port, same driver. No GPO, no MDC provisioning. |
| 🔒 | **`secure` is never modified** | You add a queue and paste a script into a text field. That is all. |
| 📄 | **No duplicate jobs** | `moveToQueue` relocates the job, it does not copy it. |
| 🌐 | **No fleet wide disruption** | The only behaviour change anywhere is that mono jobs stop appearing at the IM C2010. |
| ↩️ | **Rollback is one text field** | Clear the script and save. |

Users never see `secure_mono`. A pull print queue surfaces at a terminal based on printer membership, not on anything installed on the PC.

---

## 3. What the user experiences

```mermaid
sequenceDiagram
    autonumber
    participant U as 👤 User
    participant PC as 💻 PC driver
    participant S as 📥 secure
    participant P as 🔍 Job Parser
    participant R as ⚙️ Script
    participant M as 📥 secure_mono
    participant T as 🖨️ Terminal

    U->>PC: Print, no setting changed
    PC->>S: Job arrives on the secure share
    S->>P: Process job
    P-->>R: color, colorCount, monoCount, pageCount
    alt Colour pages present
        R-->>S: Leave in place
        U->>T: Taps card at IM C2010
        T-->>U: Job listed, releases
    else Zero colour pages
        R->>M: moveToQueue secure_mono
        R-->>U: MDC popup, if installed
        U->>T: Taps card at IM C2010
        T-->>U: Job not listed
        U->>T: Taps card at IM 2500
        T-->>U: Job listed, releases
    end
```

The job is never lost in either path. That is the point of the design, and it is what makes rollback and user communication simple.

---

## 4. Note on drivers

The `secure` queue already releases jobs across multiple printer models today, so cross model PDL handling is already proven in this environment. No driver change is needed.

---

*Next: [Pre-deployment checklist](02-pre-deployment-checklist.md)*
