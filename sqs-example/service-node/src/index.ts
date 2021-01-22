import express, { Request, Response } from "express";
import awsSdk from "aws-sdk";
import bodyparse from "body-parser";
import dotenv from "dotenv";
//config do env
dotenv.config()
//client do SQS
if (!process.env.AWS_KEY || !process.env.AWS_SECRET || !process.env.QUEUE_SQS_URL){
    throw new Error('Configure o ENV')
}
awsSdk.config.update({region: 'sa-east-1'})
const sqsClient = new awsSdk.SQS({
    credentials: {
        accessKeyId: process.env.AWS_KEY,
        secretAccessKey: process.env.AWS_SECRET,
    },
    apiVersion: '2012-11-05'
})
//servidor http express
const server = express()

server.use(bodyparse.json())

server.get('/', (req: Request, res: Response) => {
    return res.json({message: 'Server running'})
})

server.post('/send', (req: Request, res: Response) => {
    let payload = JSON.stringify(req.body)
    //enviando menssagem pra fila
    let messageParams = {
        QueueUrl: process.env.QUEUE_SQS_URL as string,
        MessageBody: payload
    }
    sqsClient.sendMessage(messageParams, (err, data) => {
        if(err){
            console.log(err)
            return;
        }
        console.log(data)
    })
    //response
    return res.json({message: 'Recived request'})
})

server.listen(3000, () => {
    console.log('Server running at 3000')
})