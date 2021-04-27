import {Entity} from "./entity";
import {EntityType} from "../entity-component/entity-type";

export interface Role extends Entity {
  type: EntityType.role,
  name: string,
  title: string,
  permissions: number[];
}
