import os
import json

def lambda_handler(event, context):
    #let make hard process
    try:
        a = event.get('a')
        b = event.get('b')
        result = a * b 
        return {
            'statusCode': 200,
            'body': result
        }
    except Exception as e:
        print(e)
        return {
            'statusCode': 500,
            'body': json.dumps('Something was wrong :(')
        }