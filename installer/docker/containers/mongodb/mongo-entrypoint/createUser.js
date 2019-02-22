db = db.getSiblingDB('admin');
db.createUser({
    user: "root",
    pwd: "root11",
    roles: [
        { role: "dbAdminAnyDatabase", db: "admin" }
    ],
    mechanisms: [ "SCRAM-SHA-1", "SCRAM-SHA-256" ],
    passwordDigestor: "server"
})
db = db.getSiblingDB('docker');  // 创建一个名为"newDB"的DB
db.createUser({
    user: "root",
    pwd: "root11",
    roles: [
        { role: "readWrite", db: "docker" }
    ],
    mechanisms: [ "SCRAM-SHA-1", "SCRAM-SHA-256" ],
    passwordDigestor: "server"
})