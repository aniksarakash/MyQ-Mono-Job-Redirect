# 1️⃣ Phase 1, Server Preparation

Four steps. Nothing after this phase works until all four are done.

---

## Step 1.1 🚨 Clear the licence error

If the banner **"MyQ is not running: There is an issue with your license"** is present, the Print Server is not processing jobs and nothing below will work.

**Settings → License.** Common causes:

| Cause | Fix |
|---|---|
| Trial expired or never activated | Activate through the MyQ partner portal |
| Installation key mismatch | Re-activate against the new installation ID |
| Assurance expired for the installed build | Renew, or roll back to a covered build |

Installation key mismatch is the usual cause after a VM clone, backup restore, or NIC or hardware change.

> ⛔ **Do not continue until the banner is gone.**

---

## Step 1.2 💾 Backup

**Easy Config → Database → Backup.** Store it off the server.

This is your only route back from a server level problem. Everything else in this runbook rolls back by clearing a text field.

---

## Step 1.3 🔓 Unlock Job Scripting

The Scripting (PHP) field is read-only by default. That is a security control added under CVE-2024-22076, not a bug.

1. On the MyQ server, open **MyQ Easy Config**
2. **Security** tab
3. Enable **Unlock PHP Scripting**
4. Save
5. **Home** tab → Stop all services → Start all services
6. Log out of the web interface and log back in

![Easy Config, Security tab, Unlock PHP Scripting enabled](assets/01-easy-config-unlock-php-scripting.png)

**Verify:** open any queue → Job Processing. The blue "Modification of Scripting (PHP) is disabled in Easy Config" bar must be gone and the field must be editable.

> 🔒 This gets switched back off in [Phase 6](08-phase-6-closeout.md). The script keeps running once locked again, only editing is blocked.

---

## Step 1.4 🔍 Enable the Job Parser

**Settings → Jobs → Job Parser**

| Option | Use when |
|---|---|
| ⛔ Basic | Not suitable. It does not estimate mono or colour pages. |
| ✅ **Standard** | Default choice for normal office documents. |
| ⚡ **Enhanced** | Heavy PDF or PostScript, or if Standard misclassifies. |

Enhanced renders every page and uses noticeably more CPU. Start with Standard.

Without a parser at Standard or above, `$this->color` and `$this->colorCount` arrive as `null` and every job takes branch 1 of the script. You will see nothing but warnings in the log.

---

## ✅ Phase 1 exit criteria

| Check | State |
|---|:---:|
| No licence banner | ☐ |
| Backup stored off server | ☐ |
| Scripting (PHP) field editable | ☐ |
| Job Parser set to Standard or Enhanced | ☐ |

---

*Next: [Phase 2, mono landing queue](04-phase-2-mono-queue.md)*
